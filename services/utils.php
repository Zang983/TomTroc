<?php
declare(strict_types=1);

/**
 * This class contain some useful methods for the project
 */
class Utils
{
    public static function checkDirectoriesAndCreate()
    {
        if (!file_exists(UPLOAD_AVATAR_DIR)) {
            mkdir(UPLOAD_AVATAR_DIR, 0777, true);
        }
        if (!file_exists(UPLOAD_BOOK_DIR)) {
            mkdir(UPLOAD_BOOK_DIR, 0777, true);
        }
    }

    /**
     * This method upload a file to the server
     * @param array $file
     * @param bool $isAvatar : if it's an avatar to change directory
     * @return string|null
     */
    public static function uploadFile(array $file, bool $isAvatar = false): string|null
    {
        $file = $file['file'];
        $target_dir = $isAvatar ? UPLOAD_AVATAR_DIR : UPLOAD_BOOK_DIR;
        Utils::checkDirectoriesAndCreate();
        if (!$file['error']) {
            $filename = time() . "_" . htmlspecialchars(basename($file['name']));
            $target_file = $target_dir . $filename;
            move_uploaded_file($file['tmp_name'], $target_file);
            return $filename;
        }
        return null;
    }

    /**
     * // This method delete a file from the server
     * @param string|null $filename
     * @param bool $isAvatar
     * @return void
     */
    public static function deleteFile(string|null $filename, bool $isAvatar = false): void
    {
        if ($filename === "no-image.svg" || !$filename) {
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
            return $minutes . " minute(s)";
        } elseif ($duration < 86400) {
            // Less than 1 day
            $hours = floor($duration / 3600);
            return $hours . " heure(s)";
        } elseif ($duration < 2592000) {
            // Less than 1 month
            $days = floor($duration / 86400);
            return $days . " jour(s)";
        } elseif ($duration < 31536000) {
            // Less than 1 year
            $months = floor($duration / 2592000);
            return $months . " mois";
        } else {
            // 1 year or more
            $years = floor($duration / 31536000);
            return $years . " année(s)";
        }
    }

    /**
     * @param string|null $filename : filename of avatar or book cover
     * @param bool $isAvatar : if it's an avatar
     * @return string : fullpath of the file
     */
    public static function filepath(string|null $filename, bool $isAvatar = false): string
    {
        if (!$filename)
            return NO_IMAGE;
        if ($isAvatar)
            return $filename == "no-image.svg" ? NO_IMAGE : "./uploads/avatar/" . $filename;

        return $filename == "no-image.svg" ? NO_IMAGE : "./uploads/books/" . $filename;
    }

    /**
     * // This method check if the input is valid, we can add more types or conditions
     * @param array $input
     * @return bool
     */
    public static function checkInput(array $input): bool
    {
        $input['value'] = trim($input['value']);
        switch ($input['type']) {
            case 'email':
                if (!filter_var($input['value'], FILTER_VALIDATE_EMAIL)) {
                    return false;
                }
                break;
            case 'password':
                if (strlen($input['value']) < 3) {
                    return false;
                }
                break;
            case 'username':
                if (strlen($input['value']) < 3) {
                    return false;
                }
                break;
            case 'text':
                if (strlen($input['value']) < 3) {
                    return false;
                }
                break;
        }
        return true;
    }

    /**
     * This method check if the form is valid.
     * @param array $inputs : form, with values and types of each inputs (email | password | username | text).
     * @return bool : true if the input is valid, false otherwise
     */
    public static function checkValidityForm(array $inputs): bool
    {
        foreach ($inputs as $entry) {
            if (!self::checkInput($entry))
                return false;
        }
        return true;
    }

    /**
     * // This method format the timestamp to differents readables formats
     * @param string $timestamp
     * @param bool $fullFormat
     * @return string
     */
    public static function formatTimestamp(string $timestamp, bool $fullFormat = false): string
    {
        $date = new DateTime($timestamp);
        $now = new DateTime();

        // Calc difference between dates
        $interval = $now->diff($date);
        if ($fullFormat) {
            return $date->format('d.m H:i');
        }
        // Check if the date is today
        if ($interval->days < 1) {
            return $date->format('H:i');
        }
        // Check if the date is before today
        return $date->format('d.m');
    }
    
    public static function truncate(string $text, int $length = 20): string
    {
        if (strlen($text) > $length)
            return substr($text, 0, $length) . "...";

        return $text;
    }

}

