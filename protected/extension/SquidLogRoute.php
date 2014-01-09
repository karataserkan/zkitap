<?php

class SquidLogRoute extends CLogRoute
{
	/*
	
	 */
	public function init()
	{
		openlog('Squid', LOG_PID, LOG_LOCAL0);
		
	}
	/*
	
	 */
	public function processLogs($logs)
	{
		foreach($logs as $log) {
			switch($log[1]) {
				case 'trace':
					$pri = LOG_DEBUG;
				case 'info':
					$pri = LOG_INFO;
				case 'profile':
					$pri = LOG_NOTICE;
				case 'warning':
					$pri = LOG_WARNING;
				case 'error':
					$pri = LOG_ERR;
			}
		if ($log[2]=='Squid') {
			syslog($pri, $log[1] . ' - ' . $log[0]);
		}
		
		}
		closelog();
	}
}
