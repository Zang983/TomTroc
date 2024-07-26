<?php
/**
 * This class contain some useful methods for the project
 */
class Utils
{

    public static function uploadFile(array $file, bool $isAvatar = false): string|null
    {
        var_dump($file);
        $file = $file['file'];
        $target_dir = $isAvatar ? UPLOAD_AVATAR_DIR : UPLOAD_BOOK_DIR;

        if (!$file['error']) {
            $filename = time() . "_" . basename($file['name']);
            $target_file = $target_dir . $filename;
            move_uploaded_file($file['tmp_name'], $target_file);
            return $filename;
        }
        return null;
    }
    public static function deleteFile(string $filename, bool $isAvatar = false): void
    {
        if ($filename === "no-image.svg") {
            return;
        }
        $target_dir = $isAvatar ? UPLOAD_AVATAR_DIR : UPLOAD_BOOK_DIR;
        if (file_exists($target_dir . $filename)) {
            unlink($target_dir . $filename);
        }
    }
    public static function redirect(string $url): void
    {
        header("Location: index.php?action=" . $url);
    }
    /**
     * @param string $timestamp : timestamp of the registration from the database
     * @return string : duration of the registration
     */
    public static function getRegistrationDuration(string $timestamp): string
    {
        $currentTime = time();
        $registrationTime = strtotime($timestamp);
        $duration = $currentTime - $registrationTime;

        if ($duration < 3600) {
            // Less than 1 hour
            $minutes = floor($duration / 60);
            return $minutes . " minutes";
        } elseif ($duration < 86400) {
            // Less than 1 day
            $hours = floor($duration / 3600);
            return $hours . " heures";
        } elseif ($duration < 2592000) {
            // Less than 1 month
            $days = floor($duration / 86400);
            return $days . " jours";
        } elseif ($duration < 31536000) {
            // Less than 1 year
            $months = floor($duration / 2592000);
            return $months . " mois";
        } else {
            // 1 year or more
            $years = floor($duration / 31536000);
            return $years . " années";
        }
    }

    /**
     * @param string|null $filename : filename of avatar or book cover
     * @param bool $isAvatar : if it's an avatar
     * @return string : fullpath of the file
     */
    public static function filepath(string|null $filename, bool $isAvatar = false): string
    {
        if (!$filename) {
            return NO_IMAGE;
        }
        if ($isAvatar) {
            return $filename == "no-image.svg" ? NO_IMAGE : "./uploads/avatar/" . $filename;
        } else {
            return $filename == "no-image.svg" ? NO_IMAGE : "./uploads/books/" . $filename;
        }
    }
}

