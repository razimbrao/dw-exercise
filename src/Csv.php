<?php

namespace Php\Dw;

class Csv
{
    private(set) array $header = [];

    public function __construct(
        private string $csv
    ) {}

    public function readCsv(): iterable
    {
        $csv = fopen($this->csv, "r");
        try {
            while(($row = fgetcsv($csv, escape: "\\")) !== false) {
                if(!count($this->header)) {
                    $row[0] = preg_replace('/^\x{FEFF}/u', '', $row[0]);
                    $this->header = $this->readRow($row[0]);
                    continue;
                }
                yield $this->readRow($row[0]);
            }
        } finally {
            fclose($csv);
        }
        return [];
    }

    /**
     * @param string $row
     * @return string[]
     */
    private function readRow(string $row): array
    {
        return explode(";", $row);
    }
}