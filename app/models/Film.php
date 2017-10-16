<?php

namespace App\Models;

use App\Vendor\Model;

class Film extends Model
{
    private $tableName = 'films';

    private static $filmFormats = ['VHS', 'DVD', 'Blu-Ray'];

    private $array_sorts = [
        'id',
        'name',
        'year',
    ];

    public function getAllFilms()
    {
        $sql = "SELECT * FROM {$this->tableName}";

        $whereStatements = [];

        if (!is_null($this->request->search_name) && strlen($this->request->search_name)) {
            $whereStatements[] = "`name` LIKE '%" . $this->db->escape($this->request->search_name) . "%'";
        }

        if (!is_null($this->request->search_actor) && strlen($this->request->search_actor)) {
            $whereStatements[] = "`actors` LIKE '%" . $this->db->escape($this->request->search_actor) . "%'";
        }

        if (!empty($whereStatements)) {
            $sql .= ' WHERE ' . implode(' AND ', $whereStatements);
        }

        $defaultSort = 'id';

        if (!is_null($this->request->sort) && in_array($this->request->sort, $this->array_sorts)) {
            $sql .= ' ORDER BY ' . $this->request->sort;
        } else {
            $sql .= ' ORDER BY ' . $defaultSort;
        }

        if (!is_null($this->request->order) && $this->request->order == 'asc') {
            $sql .= ' ASC';
        } else {
            $sql .= ' DESC';
        }

        $std = $this->db->query($sql);

        if ($std->num_rows) {
            array_walk($std->rows, function (&$record) {
                if (strlen($record['actors']) && is_json($record['actors'])) {
                    $record['actors'] = $this->getActorsArrayFromJson($record['actors']);
                }
            });
        }

        return $std->rows;
    }

    public function newRecord()
    {
        $actors = $this->getActorsJsonFromRequest();

        $sql = "INSERT INTO {$this->tableName} (`name`, `year`, `format`, `actors`) 
            VALUES ('" . $this->db->escape($this->request->name) . "', 
            '" . $this->db->escape($this->request->year) . "', 
            '" . $this->db->escape($this->request->format) . "', 
            '{$actors}')";

        $this->db->query($sql);

        return $this->db->getLastId();
    }

    public function getRecord($id)
    {
        $std = $this->db->query("SELECT * FROM {$this->tableName} WHERE `id` = {$id}");

        if ($std->num_rows > 0) {
            return [
                'id' => $std->row['id'],
                'name' => $std->row['name'],
                'year' => $std->row['year'],
                'format' => $std->row['format'],
                'actors' => $this->getActorsArrayFromJson($std->row['actors']),
            ];
        } else {
            return null;
        }
    }

    public function updateRecord($id)
    {
        $actors = $this->getActorsJsonFromRequest();

        $sql = "UPDATE {$this->tableName} SET
            `name` = '" . $this->db->escape($this->request->name) . "',
            `year` = '" . $this->db->escape($this->request->year) . "',
            `format` = '" . $this->db->escape($this->request->format) . "',
            `actors` = '$actors' WHERE `id` = '" . (int)$id . "'";

        $this->db->query($sql);
    }

    public function deleteRecord($id)
    {
        $this->db->query("DELETE FROM {$this->tableName} WHERE `id` = " . (int)$id);
    }

    public function saveMany($films)
    {

        $sql = "INSERT INTO {$this->tableName} (`name`, `year`, `format`, `actors`) VALUES";

        $sqlValues = [];

        foreach ($films as $film) {
            $sqlValues[] = "('{$film['name']}', '{$film['year']}', '{$film['format']}', '{$film['actors']}')";
        }

        $sqlValues = implode(', ', $sqlValues);

        $sql .= $sqlValues;

        $this->db->query($sql);
    }

    private function getActorsJsonFromRequest()
    {
        return json_encode(preg_split("/\r\n|\n|\r/", $this->request->actors, -1, PREG_SPLIT_NO_EMPTY), JSON_UNESCAPED_UNICODE);
    }

    private function getActorsArrayFromJson($actors)
    {
        return implode("\n", json_decode($actors));
    }

    public static function getFilmFormats()
    {
        return self::$filmFormats;
    }
}
