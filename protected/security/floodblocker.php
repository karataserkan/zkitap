<?php

// ----------------------------------------------------------------------------
//
// class.floodblocker.php - FloodBlocker class, ver.0.01 (April 15, 2005)
//
// Description:
//   Class allowing to protect the scripts from flooding and to prevent
//   automatic download of the site from single IP.
//
// Author:
//   Vagharshak Tozalakyan <vagh@armdex.com>
//   This module was written by author on its leasure time.
//
// Warning:
//   This class is non commercial, non professional work. It should not have
//   unexpected results. However, if any damage is caused by this class the
//   author can not be responsible. The use of this class is at the risk of
//   the user.
//
// Requirements:
//   PHP >= 4.1.0
//
// ----------------------------------------------------------------------------


// Errors and warnings

define ( 'E_TMP_DIR',    'Incorrect temprorary directory specified.' );
define ( 'E_IP_ADDR',    'Incorrect IP address specified.' );
define ( 'E_LOG_FILE',   'Log file access error! Check permissions to write.' );
define ( 'E_CRON_FNAME', 'The name of cron file must begin with dot.' );
define ( 'E_CRON_FILE',  'Cron file access error! Check permissions to write.' );
define ( 'E_CRON_JOB',   'Unable to perform the cron job.' );


// Class definition

class FloodBlocker
{

  // The directory where log files will be saved. Must have permissions to write.
  var $logs_path;

  // IP address of current connection. REMOTE_ADDR will be used by default.
  var $ip_addr;

  // An associative array of [$interval=>$limit] format, where $limit is the
  // number of possible requests during $interval seconds.
  var $rules;

  // The name of the cron file. Must begin with dot. Default filename is '.time'.
  var $cron_file;

  // Cron execution interval in seconds. 1800 secs (30 mins) by default.
  var $cron_interval;

  // After how many of seconds to consider a file as old? By default the files
  // will consider as old after 7200 secs (2 hours).
  var $logs_timeout;


  /*
    Description:
      Class constructor.
    Prototype:
      void FloodBlocker ( string logs_path, string ip = '' )
    Parameters:
      logs_path - the directory where log files will be saved
      ip - the ip address of the current connection,
           $_SERVER['REMOTE_ADDR'] will be used if ip=''
  */
  function FloodBlocker ( $logs_path, $ip = '' )
  {

    if ( ! is_dir ( $logs_path ) )
      trigger_error ( E_TMP_DIR, E_USER_ERROR );

    $logs_path = str_replace ( '\\', '/', $logs_path );
    if ( substr ( $logs_path, -1 ) != '/' )
      $logs_path .= '/';

    $this->logs_path = $logs_path;

    if ( empty ( $ip ) )
      $ip = $_SERVER['REMOTE_ADDR'];

    $ip = ip2long ( $ip );
    if ( $ip == -1 || $ip === FALSE )
      trigger_error ( E_IP_ADDR, E_USER_ERROR );

    $this->ip_addr = $ip;

    $this->rules = array ( );
    $this->cron_file = '.time';
    $this->cron_interval = 1800;  // 30 minutes
    $this->logs_timeout = 7200;  // 2 hours

  }


  /*
    Description:
      Used to check flooding. Generally this function acts as private method
      and will be called internally by public methods. However, it can be called
      directly when storing logs in db.
    Prototype:
      bool RawCheck ( array &info )
    Parameters:
      info - $interval=>$time, $interval=>$count array
    Return:
      FALSE if flood detected, otherwise - TRUE.
  */
  function RawCheck ( &$info )
  {

    $no_flood = TRUE;

    foreach ( $this->rules as $interval=>$limit )
    {
      if ( ! isset ( $info[$interval] ) )
      {
        $info[$interval]['time'] = time ( );
        $info[$interval]['count'] = 0;
      }

      $info[$interval]['count'] += 1;

      if ( time ( ) - $info[$interval]['time'] > $interval )
      {
        $info[$interval]['count'] = 1;
        $info[$interval]['time'] = time ( );
      }

      if ( $info[$interval]['count'] > $limit )
      {
        $info[$interval]['time'] = time ( );
        $no_flood = FALSE;
      }

      // The following two lines can be used for debugging
      // echo $info[$interval]['count'].'  ';
      // echo $info[$interval]['time'].'<br>';

    }  // foreach

    return $no_flood;

  }


  /*
    Description:
      Checks flooding. Must be called after setting up all necessary properties.
    Prototype:
      bool CheckFlood ( )
    Return:
      FALSE if flood detected, otherwise - TRUE.
  */
  function CheckFlood ( )
  {

    $this->CheckCron ( );

    $path = $this->logs_path . $this->ip_addr;

    if ( ! ( $f = fopen ( $path, 'a+' ) ) )
      trigger_error ( E_LOG_FILE, E_USER_ERROR);

    flock ( $f, LOCK_EX );

    $info = fread ( $f, filesize ( $path ) + 10 );
    $info = unserialize( $info );

    $result = $this->RawCheck ( $info );

    ftruncate ( $f, 0 );
    fwrite ( $f, serialize( $info ) );
    fflush ( $f );

    flock($f, LOCK_UN);

    fclose($f);

    return $result;

  }


  /*
    Description:
      Checks the cron file and calls CronJob() to delete old entries from logs
      directory if the time-out is reached.
    Prototype:
      void CheckCron ( )
  */
  function CheckCron ( )
  {

    if ( substr ( $this->cron_file, 0, 1 ) != '.' )
    {
      trigger_error ( E_CRON_FNAME, E_USER_WARNING );
      return;
    }

    $path = $this->logs_path . $this->cron_file;

    if ( ! ( $f = fopen ( $path, 'a+' ) ) )
    {
      trigger_error ( E_CRON_FILE, E_USER_WARNING );
      return;
    }

    flock ( $f, LOCK_EX );

    $last_cron = fread ( $f, filesize ( $path ) + 10 );
    $last_cron = abs ( intval ( $last_cron ) );

    if ( time ( ) - $last_cron > $this->cron_interval )
    {
      $this->CronJob ( );
      $last_cron = time ( );
    }

    ftruncate ( $f, 0 );
    fwrite ( $f, $last_cron );
    fflush ( $f );

    flock ( $f, LOCK_UN );

    fclose ( $f );

  }


  /*
    Description:
      Deletes all old files from logs directory, except the files starting
      with dot.
    Prototype:
      void CronJob ( )
  */
  function CronJob ( )
  {

    $path = $this->logs_path;

    if ( ! ( $dir_hndl = opendir ( $this->logs_path ) ) )
    {
      trigger_error ( E_CRON_JOB, E_USER_WARNING);
      return;
    }

    while ( $fname = readdir ( $dir_hndl ) )
    {
      if ( substr( $fname, 0, 1 ) == '.' )
        continue;
      clearstatcache ( );
      $ftm = filemtime ( $path . $fname );
      if ( time ( ) - $ftm > $this->logs_timeout )
        @unlink ( $path . $fname );
    }

    closedir ( $dir_hndl );

  }

}  // end of class definition



/*
  $flb = new FloodBlocker ( 'example/tmp-ips/' );
  $flb->rules = array ( 10=>5 );
  $res = $flb->CheckFlood ( );
  if ( $res )
    echo 'Succeed!';
  else
    die ( 'Too many requests! Please try later.' );
*/

?>