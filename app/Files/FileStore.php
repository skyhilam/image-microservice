<?php

namespace App\Files;

use Illuminate\Filesystem\FilesystemManager;
use Ramsey\Uuid\Uuid;

class FileStore
{
	protected $filesystemManager;

	protected $folder;

    protected $filename = null;

	public function __construct(FilesystemManager $filesystemManager)
	{
		$this->filesystemManager = $filesystemManager;
	}

	public function get($filename = null)
	{
		return $this->filesystemManager->get($this->path($filename));
	}

	public function url($filename = null)
	{
		return $this->filesystemManager->url($this->path($filename));
	}

	public function folder($folder)
	{
		$this->folder = $folder;

		return $this;
	}

    public function filename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

	public function exists($filename = null)
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

	public function copy($filename = null)
	{
		$this->filesystemManager->copy(
			$this->path($filename),
			$this->path($new_filename = Uuid::uuid4()->toString())
		);

		return $new_filename;
	}

	public function delete($filename = null)
	{
		if ($this->exists($filename)) {
			$this->filesystemManager->delete($this->path($filename));
		};
	}

	public function path($filename = null)
	{
		return $this->folder. '/'. ($filename ?? $this->filename);
	}

    public function getDriver()
    {
        return $this->filesystemManager->getDriver();
    }

    public function getAdapter()
    {
        return $this->filesystemManager->getAdapter();
    }

    public function mimetype($filename = null)
    {
        return $this->filesystemManager->getMimetype($this->path($filename));
    }

}
