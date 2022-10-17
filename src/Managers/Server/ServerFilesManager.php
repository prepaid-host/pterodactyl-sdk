<?php

namespace HCGCloud\Pterodactyl\Managers\Server;

use HCGCloud\Pterodactyl\Managers\Manager;
use HCGCloud\Pterodactyl\Resources\Collection;
use HCGCloud\Pterodactyl\Resources\ServerFiles;

class ServerFilesManager extends Manager
{
    /**
     * Get a list of existing directorys in server files.
     *
     * @param mixed $serverId
     * @param array $query
     *
     * @return Collection
     */
    public function list($serverId, $directory = "/", array $query = [])
    {
        return $this->http->get("servers/$serverId/files/list", array_merge([
            'directory' => $directory,
        ], $query));
    }

    /**
     * Get contents of a specific file.
     *
     * @param mixed $serverId
     * @param string $filePath
     * @param array $query
     *
     * @return ServerFile
     */
    public function contentsOfFile($serverId, $filePath, array $query = [])
    {
        return $this->http->get("servers/$serverId/files/contents", array_merge([
            'file' => $filePath,
        ], $query));
    }

    /**
     * Download a file (returns an direct url with token).
     *
     * @param mixed $serverId
     * @param string $filePath
     * @param array $query
     *
     * @return ServerFile
     */
    public function downloadFile($serverId, $filePath, array $query = [])
    {
        return $this->http->get("servers/$serverId/files/download", array_merge([
            'file' => $filePath,
        ], $query));
    }

    /**
     * Rename a file.
     *
     * @param mixed $serverId
     * @param string $oldName
     * @param string $newName
     * @param array $query
     *
     * @return ServerFile
     */
    public function renameFile($serverId, $folder, $oldName, $newName, array $query = [])
    {
        return $this->http->put("servers/$serverId/files/rename", null, array("root" => $folder ?? "/", "files" => array("from" => $oldName, "to" => $newName)));
    }

    public function getFileUploadData($serverId) {
        return $this->http->get("servers/$serverId/files/upload");
    }
    /**
     * Write content to a file.
     *
     * @param mixed $serverId
     * @param string $filePath
     * @param array $fileContent
     * @param array $query
     *
     * @return ServerFile
     */
    public function writeDataToFile($serverId, $filePath, $fileContent, array $query = [])
    {
        return $this->http->put("servers/$serverId/files/write", array_merge([
            'file' => $filePath,
        ], $query), $fileContent);
    }


    /**
     * Delete a file.
     *
     * @param mixed $serverId
     * @param string $folder
     * @param array $files
     *
     * @return ServerFile
     */
    public function deleteFile($serverId, $folder, $files)
    {
        return $this->http->put("servers/$serverId/files/delete", null, array("root" => $folder ?? "/", "files" => $files));
    }


}
