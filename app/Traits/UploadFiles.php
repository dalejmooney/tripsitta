<?php

namespace App\Traits;

use A17\Twill\Models\File;
use A17\Twill\Models\Media;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadFiles{
    public function saveFileAndAttach(UploadedFile $file_to_upload, User $user, $role)
    {
        $safe_file_name = $this->getSafeFileName($file_to_upload->getClientOriginalName());
        $fileDirectory = $this->getUniqueDirName();

        $file = $this->saveFile($file_to_upload, $fileDirectory, $safe_file_name);

        if($file)
        {
            $user->babysitter->files()->attach($file->id, ['role' => $role, 'locale' => config('app.locale')]);
        }
    }

    public function saveMediaFileAndAttach(UploadedFile $file_to_upload, User $user, $role)
    {
        $safe_file_name = $this->getSafeFileName($file_to_upload->getClientOriginalName());
        $fileDirectory = $this->getUniqueDirName();

        $file = $this->saveMediaFile($file_to_upload, $fileDirectory, $safe_file_name);

        if($file)
        {
            $user->babysitter->medias()->attach($file->id, [
                'role' => $role,
                'locale' => config('app.locale'),
                'crop' => 'default',
                'crop_x' => 0,
                'crop_y' => 0,
                'crop_w' => 0,
                'crop_h' => 0,
                'ratio' => 'default',
                'metadatas' => '{"caption":null,"altText":null,"video":null}']
            );
        }
    }

    public function saveManyFilesAndAttach($files_to_upload, User $user, $role)
    {
        $fileDirectory = $this->getUniqueDirName();

        foreach($files_to_upload as $file)
        {
            $safe_file_name = $this->getSafeFileName($file->getClientOriginalName());
            $file = $this->saveFile($file, $fileDirectory, $safe_file_name);

            if($file)
            {
                $user->babysitter->files()->attach($file->id, ['role' => $role, 'locale' => config('app.locale')]);
            }
        }
    }

    public function removeExistingFiles(User $user, $role)
    {
        $files = $user->babysitter->files()->where('role', $role)->where('locale', config('app.locale'))->get();

        if(count($files) == 0) return true;

        $user->babysitter->files()->where('role', $role)->where('locale', config('app.locale'))->detach();
        File::destroy($files->pluck('id')->toArray());

        return count($files);
    }

    public function removeExistingMediaFiles(User $user, $role)
    {
        $files = $user->babysitter->medias()->where('role', $role)->where('locale', config('app.locale'))->get();

        if(count($files) == 0) return true;

        $user->babysitter->medias()->where('role', $role)->where('locale', config('app.locale'))->detach();
        Media::destroy($files->pluck('id')->toArray());

        return count($files);
    }

    private function saveFile(UploadedFile $file_to_upload, $fileDirectory, $safe_file_name)
    {
        $disk = config('twill.file_library.disk');

        $file_to_upload->storeAs($fileDirectory, $safe_file_name, $disk);

        $uuid = $fileDirectory . '/' . $safe_file_name;

        $fields = [
            'uuid' => $uuid,
            'filename' => $safe_file_name,
            'size' => $file_to_upload->getSize(),
        ];

        $file = File::create($fields);

        if($file) return $file;
        return false;
    }

    private function saveMediaFile(UploadedFile $file_to_upload, $fileDirectory, $safe_file_name)
    {
        $disk = config('twill.media_library.disk');

        $file_to_upload->storeAs($fileDirectory, $safe_file_name, $disk);

        $uuid = $fileDirectory . '/' . $safe_file_name;

        $filePath = Storage::disk($disk)->path($fileDirectory . '/' . $safe_file_name);
        list($w, $h) = getimagesize($filePath);

        $fields = [
            'uuid' => $uuid,
            'filename' => $safe_file_name,
            'alt_text' => '',
            'width' => $w,
            'height' => $h,
        ];

        $file = Media::create($fields);

        if($file) return $file;
        return false;
    }

    private function getSafeFileName($file_name)
    {
        return sanitizeFilename($file_name);
    }

    private function getUniqueDirName()
    {
        return uniqid('', true);
    }
}
