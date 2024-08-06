<?php
/**
 * This class contain some useful methods for the project
 */
class Utils
{

    public static function uploadFile(array $file, bool $isAvatar = false): string|null
    {
        $file = $file['file'];
        $target_dir = $isAvatar ? UPLOAD_AVATAR_DIR : UPLOAD_BOOK_DIR;

        if (!$file['error']) {
            $filename = time() . "_" . htmlspecialchars(basename($file['name']));
            $target_file = $target_dir . $filename;
            move_uploaded_file($file['tmp_name'], $target_file);
            return $filename;
        }
        return null;
    }
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
    public static function secureInput(string $input): string
    {
        return htmlspecialchars($input);
    }
    public static function formatTimestamp($timestamp)
    {
        // Convertir le timestamp en objet DateTime
        $date = new DateTime($timestamp);
        $now = new DateTime();

        // Calculer la différence entre maintenant et la date du timestamp
        $interval = $now->diff($date);

        // Vérifier si la différence est inférieure à 24 heures
        if ($interval->days < 1) {
            // Retourner l'heure au format hh:mm
            return $date->format('H:i');
        }
        // Retourner la date au format jj.mm
        return $date->format('d.m');
    }

}

