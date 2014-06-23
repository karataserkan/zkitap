<?php 

/**
* OKUTUS mailer
* 
* Yii::app()->Smtpmail; ile Controller arasında çalışır
* controlerdan aldığı bilgileri konfigure ederek Smtpmaile sunar
* 
*/
class Email
{
	/**
	*From address: epostanın gönderileceği hesap
	*/
	public $from ='';


	/**
	*To addresses: epostanın gideceği hesaplar
	*/
	public $to =array();


	/**
	 * Subject: Epostanın konusu
	 */
	public $subject = '';


	/**
	 * Mail file: Gidecek eposta.html'in adresi
	 */
	public $file = '';


	/**
	 * Mail Attributes: Belirtilen mail dosyasındaki değişkenler.
	 * Mail fosyasındaki %%TEXT%% ile array'in key'inin aynı olması gerekmektedir.
	 * Örnek: 
	 * htmlde: %%title%%
	 * arrayde:['title']=>'Eposta'
	 */
	public $attributes = array();


	/**
	 * Mail Body: HTML dosyanın alınarak değişkenlerin eklenmiş hali | Gönderilecek Mesaj
	 */
	public $mailBody ='';

	function __construct()
	{
		$this->setFrom(Yii::app()->params['noreplyEmail']);
	}

	public function sendMail(){
		$mail=Yii::app()->Smtpmail;
		$mail->SetFrom($this->getFrom(),"OKUTUS");
		$mail->Subject=$this->getSubject();
		
		error_log("file:".$this->getFile());

		$this->setMailBody();

		error_log($this->getMailBody());

		$to=$this->getTo();
		foreach ($to as $key => $address) {
			$mail->AddAddress($address, "");
		}

		$mail->MsgHTML($this->getMailBody());
		if($mail->Send()) {
			return true;
		}else{
			return false;
		}
	}

    /**
     * Gets the From address: epostanın gönderileceği hesap.
     *
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Sets the From address: epostanın gönderileceği hesap.
     *
     * @param mixed $from the from
     *
     * @return self
     */
    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Gets the To addresses: epostanın gideceği hesaplar.
     *
     * @return mixed
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Sets the To addresses: epostanın gideceği hesaplar.
     *
     * @param mixed $to the to
     *
     * @return self
     */
    public function setTo($to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * Gets the Subject: Epostanın konusu.
     *
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Sets the Subject: Epostanın konusu.
     *
     * @param mixed $subject the subject
     *
     * @return self
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Gets the Mail file: Gidecek eposta.html'in adresi.
     *
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Sets the Mail file: Gidecek eposta.html'in adresi.
     *
     * @param mixed $file the file
     *
     * @return self
     */
    public function setFile($file)
    {
        $this->file = Yii::app()->getBaseUrl(true).'/email/'.$file;

        return $this;
    }

    /**
     * Gets the Mail Attributes: Belirtilen mail dosyasındaki değişkenler.
	*Mail fosyasındaki %%TEXT%% ile array'in key'inin aynı olması gerekmektedir.
	*Örnek:
	*htmlde: %%title%%
	*arrayde:['title']=>'Eposta'.
     *
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Sets the Mail Attributes: Belirtilen mail dosyasındaki değişkenler.
	*Mail fosyasındaki %%TEXT%% ile array'in key'inin aynı olması gerekmektedir.
	*Örnek:
	*htmlde: %%title%%
	*arrayde:['title']=>'Eposta'.
     *
     * @param mixed $attributes the attributes
     *
     * @return self
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Gets the Mail Body: HTML dosyanın alınarak değişkenlerin eklenmiş hali | Gönderilecek Mesaj.
     *
     * @return mixed
     */
    public function getMailBody()
    {
        return $this->mailBody;
    }

    /**
     * Sets the Mail Body: HTML dosyanın alınarak değişkenlerin eklenmiş hali | Gönderilecek Mesaj.
     *
     * @param mixed $mailBody the mail body
     *
     * @return self
     */
    public function setMailBody()
    {
    	$file=$this->getFile();

    	$message=file_get_contents($file);


    	$attributes=$this->getAttributes();

    	foreach ($attributes as $key => $attribute) {
    		$message=str_replace('%'.$key.'%', $attribute, $message);
    	}

    	$this->mailBody=$message;

    }
}

?>