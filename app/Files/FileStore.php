<?php 

namespace App\Files;

use Illuminate\Filesystem\FilesystemManager;
use Ramsey\Uuid\Uuid;

class FileStore
{
	protected $filesystemManager;

	protected $folder;

	public function __construct(FilesystemManager $filesystemManager)
	{
		$this->filesystemManager = $filesystemManager;
	}

	public function get($filename) 
	{
		return $this->filesystemManager->get($this->path($filename));
	}

	public function url($filename) 
	{
		return $this->filesystemManager->url($this->path($filename));
	}

	public function folder($folder) 
	{
		$this->folder = $folder;

		return $this;
	}

	public function exists($filename) 
	{
		return $this->filesystemManager->exists($this->path($filename));
	}

	public function put($file) 
	{
		$filename = Uuid::uuid4()->toString();

		$this->filesystemManager->put(
			$this->path($filename),
			file_get_contents($file->getRealPath())
		);

		return $filename;
	}

	public function delete($filename) 
	{
		if ($this->exists($filename)) {
			$this->filesystemManager->delete($this->path($filename));
		};	
	}

	protected function path($filename) 
	{
		return $this->folder. '/'. $filename;
	}

/*

	

	

	protected function generateFilename() 
	{
		return str_random(64);
	}

*/
	
}