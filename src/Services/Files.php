<?php

namespace Nylas\Services;

use Nylas\Exceptions\Exception;
use Nylas\Helpers\Collection;
use Nylas\Resources\File;
use Psr\Http\Message\StreamInterface;

/**
 * Class Files
 *
 * @package Nylas\Services
 */
class Files extends Service
{
    const PATH_FILES = '/files';
    const PATH_FILE = '/files/%s';
    const PATH_FILE_DOWNLOAD = '/files/%s/download';

    /**
     * Get all files
     *
     * @param array $filters
     * @return Collection|Files[]
     */
    public function getFiles($filters = [])
    {
        return (new Collection(
            $this->request()->withBearerTokenAuth()->setPath(self::PATH_FILES), File::class)
        )->where($filters);
    }

    /**
     * Get a file
     *
     * @param $id
     * @return File
     * @throws Exception
     */
    public function getFile($id)
    {
        return new File($this->request()->withBearerTokenAuth()->setPath(sprintf(self::PATH_FILE, $id))->get()->toJson());
    }

    /**
     * @param $id
     * @return StreamInterface
     * @throws Exception
     */
    public function downloadFile($id)
    {
        return $this->request()->withBearerTokenAuth()->setPath(sprintf(self::PATH_FILE_DOWNLOAD, $id))->get()->toStream();
    }

    /**
     * Upload a file to Nylas
     *
     * @param string $file_name
     * @return File[]
     * @throws Exception
     */
    public function createFile(string $file_name)
    {
        $files = [];
        $response = $this->request()
            ->withBearerTokenAuth()
            ->setPath(self::PATH_FILES)
            ->setHeader('Content-Type', 'multipart/form-data')
            ->setBody([
                "name" => "file",
                "filename" => basename($file_name),
                "contents" => fopen($file_name, 'r')
            ])
            ->post()
            ->toArray()
        ;
        foreach ($response as $file) {
            $files[] = new File($file);
        }
        return $files;
    }

    /**
     * Delete a file on Nylas
     *
     * @param $id
     * @return bool
     * @throws Exception
     */
    public function deleteFile($id)
    {
        return $this->request()
            ->setPath(sprintf(self::PATH_FILES, $id))
            ->delete()
            ->isSuccess()
            ;
    }

}
