<?php

namespace Classes;

/**
 * Class Pagination
 * Manages pagination functionality.
 */
class Pagination
{
    /**
     * @var int $current_page The current page number.
     */
    public $current_page;

    /**
     * @var int $records_per_page The number of records to display per page.
     */
    public $records_per_page;

    /**
     * @var int $total_records The total number of records.
     */
    public $total_records;


    /**
     * Constructor for Pagination class.
     *
     * @param int $current_page The current page number.
     * @param int $records_per_page The number of records to display per page.
     * @param int $total_records The total number of records.
     */
    public function __construct(int $current_page = 1, int $records_per_page = 10, int $total_records = 0)
    {
        $this->current_page = $current_page;
        $this->records_per_page = $records_per_page;
        $this->total_records = $total_records;
    }


    /**
     * Calculates the offset for database queries based on the current page and records per page.
     *
     * @return int The calculated offset for database queries.
     */
    public function offset(): int
    {
        return $this->records_per_page * ($this->current_page - 1);
    }


    /**
     * Calculates the total number of pages based on the total number of records and records per page.
     *
     * @return int The total number of pages.
     */
    public function total_pages(): int
    {
        $total = ceil($this->total_records / $this->records_per_page);
        $total == 0 ? $total = 1 : $total = $total;
        return $total;
    }

    /**
     * Retrieves the previous page number.
     *
     * @return int|false The previous page number if available, otherwise false.
     */
    public function previous_page(): int|false
    {
        $previous = $this->current_page - 1;
        return ($previous > 0) ? $previous : false;
    }

    /**
     * Retrieves the next page number.
     *
     * @return int|false The next page number if available, otherwise false.
     */
    public function next_page()
    {
        $next = $this->current_page + 1;
        return ($next <= $this->total_pages()) ? $next : false;
    }

    /**
     * Generates the HTML link for the previous page.
     *
     * @return string HTML link for the previous page if available, otherwise an empty string.
     */
    public function previous_link()
    {
        $html = '';
        if ($this->previous_page()) {
            $html .= "<a class=\"paginacion__enlace paginacion__enlace--texto\" href=\"?page={$this->previous_page()}\">&laquo; Anterior </a>";
        }
        return $html;
    }

    /**
     * Generates the HTML link for the next page.
     *
     * @return string HTML link for the next page if available, otherwise an empty string.
     */
    public function next_link(): string
    {
        $html = '';
        if ($this->next_page()) {
            $html .= "<a class=\"paginacion__enlace paginacion__enlace--texto\" href=\"?page={$this->next_page()}\">Siguiente &raquo;</a>";
        }
        return $html;
    }

    /**
     * Generates the HTML for page numbers.
     *
     * @return string HTML for page numbers.
     */
    public function page_numbers(): string
    {
        $html = '';
        for ($i = 1; $i <= $this->total_pages(); $i++) {
            if ($i === $this->current_page) {
                $html .= "<span class=\"paginacion__enlace paginacion__enlace--actual \">{$i}</span>";
            } else {
                $html .= "<a class=\"paginacion__enlace paginacion__enlace--numero \" href=\"?page={$i}\">{$i}</a>";
            }
        }

        return $html;
    }

    /**
     * Generates the pagination HTML.
     *
     * @return string Pagination HTML.
     */
    public function pagination(): string
    {
        $html = '';
        if ($this->total_records > 1) {
            $html .= '<div class="paginacion">';
            $html .= $this->previous_link();
            $html .= $this->page_numbers();
            $html .= $this->next_link();
            $html .= '</div>';
        }

        return $html;
    }
}
