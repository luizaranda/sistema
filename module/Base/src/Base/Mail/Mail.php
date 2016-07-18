<?php

namespace Base\Mail;

use Zend\Mail\Transport\Smtp as SmtpTrasport;
use Zend\View\Model\ViewModel;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
use Zend\Mail\Message;

class Mail
{

	protected $transport;
	protected $view;
	protected $body;
	protected $message;
	protected $subject;
	protected $to;
	protected $data;
	protected $page;

	public function __construct(SmtpTrasport $transport, $view, $page)
	{
		$this->transport = $transport;
		$this->view      = $view;
		$this->page      = $page;
	}

	/**
	 * @return mixed
	 */
	public function getView()
	{
		return $this->view;
	}

	/**
	 * @param mixed $view
	 */
	public function setView($view)
	{
		$this->view = $view;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getBody()
	{
		return $this->body;
	}

	/**
	 * @param mixed $body
	 */
	public function setBody($body)
	{
		$this->body = $body;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getMessage()
	{
		return $this->message;
	}

	/**
	 * @param mixed $message
	 */
	public function setMessage($message)
	{
		$this->message = $message;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getSubject()
	{
		return $this->subject;
	}

	/**
	 * @param mixed $subject
	 */
	public function setSubject($subject)
	{
		$this->subject = $subject;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getTo()
	{
		return $this->to;
	}

	/**
	 * @param mixed $to
	 */
	public function setTo($to)
	{
		$this->to = $to;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * @param mixed $data
	 */
	public function setData($data)
	{
		$this->data = $data;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPage()
	{
		return $this->page;
	}

	/**
	 * @param mixed $page
	 */
	public function setPage($page)
	{
		$this->page = $page;

		return $this;
	}


	public function renderView($page, $data = [])
	{
		$model = new ViewModel();
		$model->setTemplate("mailer/{$page}.phtml");
		$model->setOption('has_parent', true);
		$model->setVariables($data);

		return $this->view->render($model);
	}

	public function prepare()
	{
		$html = new MimePart($this->renderView($this->getPage(), $this->getData()));
		$html->setType('text/html');

		$body = new MimeMessage();
		$body->setParts([$html]);
		$this->setBody($body);

		$config  = $this->transport->getOptions()->toArray();
		$message = new Message();
		$message->addFrom($config['connection_config']['from'])
		        ->addTo($this->getTo())
		        ->setSubject($this->getSubject())
		        ->setBody($this->getBody());
		$this->setMessage($message);

		return $this;
	}

	public function send()
	{
		$this->transport->send($this->getMessage());
	}

}
