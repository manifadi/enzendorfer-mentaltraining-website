<?php

require_once 'Config.php';

class DataManager
{

    private $dataFile;

    public function __construct()
    {
        $this->dataFile = Config::getDataPath();
        if (!file_exists($this->dataFile)) {
            // Create default file if not exists
            file_put_contents($this->dataFile, json_encode([]));
        }
    }

    public function getSections()
    {
        $json = file_get_contents($this->dataFile);
        $data = json_decode($json, true);
        return $data ?: [];
    }

    public function getSectionById($id)
    {
        $sections = $this->getSections();
        foreach ($sections as $section) {
            if ($section['id'] === $id) {
                return $section;
            }
        }
        return null; // Not found
    }

    public function saveSections($sections)
    {
        // Pretty print for easier manual debugging if needed
        return file_put_contents($this->dataFile, json_encode($sections, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public function updateSection($id, $newData)
    {
        $sections = $this->getSections();
        foreach ($sections as &$section) {
            if ($section['id'] === $id) {
                // Merge data. Only update fields that are passed.
                // Depending on requirement, might want to replace entirely or merge.
                // Here we replace the 'data' part if provided, or top level keys.

                // If $newData contains 'data' key, we merge/replace that specifically
                if (isset($newData['data']) && is_array($newData['data'])) {
                    $section['data'] = array_merge($section['data'], $newData['data']);
                    unset($newData['data']); // Remove it so we don't double merge
                }

                // Merge top level keys like 'visible', 'name'
                $section = array_merge($section, $newData);

                $this->saveSections($sections);
                return true;
            }
        }
        return false;
    }
}
