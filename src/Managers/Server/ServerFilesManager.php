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
     * @param string $directory
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
     * Download a file (returns a direct url with token).
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
     * @param string $folder
     * @param string $oldName
     * @param string $newName
     * @param array $query
     *
     * @return ServerFile
     */
    public function renameFile($serverId, $folder, $oldName, $newName, array $query = [])
    {
        return $this->http->put("servers/$serverId/files/rename", [], array("root" => $folder ?? "/", "files" => array(array("from" => $oldName, "to" => $newName))));
    }

    /**
     * Change permissions of a file.
     *
     * @param mixed $serverId
     * @param string $folder
     * @param string $file
     * @param int $permissions
     * @param array $query
     *
     * @return ServerFile
     */
    public function changeFilePermissions($serverId, $folder, $file, $permissions, array $query = [])
    {
        return $this->http->post("servers/$serverId/files/chmod", [], array("root" => $folder ?? "/", "files" => array(array("file" => $file, "mode" => $permissions))));
    }


    /**
     * Retrieve url to upload a file to root directory.
     *
     * @param mixed $serverId
     *
     * @return ServerFile
     */
    public function getFileUploadData($serverId) {
        return $this->http->get("servers/$serverId/files/upload");
    }

    /**
     * Write content to a file.
     *
     * @param mixed $serverId
     * @param string $filePath
     * @param string $fileContent
     * @param array $query
     *
     * @return ServerFile
     */
    public function writeDataToFile($serverId, $filePath, $fileContent, array $query = [])
    {
        return $this->http->post("servers/$serverId/files/write", array_merge([
            'file' => $filePath,
        ], $query), array(), $fileContent);
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
        return $this->http->post("servers/$serverId/files/delete", [], array("root" => $folder ?? "/", "files" => $files));
    }

    /**
     * Create a folder.
     *
     * @param mixed $serverId
     * @param string $folder
     * @param array $files
     *
     * @return ServerFile
     */
    public function createFolder($serverId, $folder, $name)
    {
        return $this->http->post("servers/$serverId/files/create-folder", [], array("root" => $folder ?? "/", "name" => $name));
    }


}
