<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 *  Courses Infos filtering
 *
 *  This filter generate informations
 *
 * @package    filter
 * @subpackage mirocoursesinfos
 * @copyright  2021 Samuel Calegari <samuel.calegari@univ-perp.fr>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class filter_mirocoursesinfos extends moodle_text_filter{

    public function filter($text, array $options = array()) {

        $html = '';

        if (!is_string($text) or empty($text)) {
            return $text;
        }

        if (strpos($text, '[coursesinfos') === false && strpos($text, '[coursestitle') === false) {
            return $text;
        }

        $regex = '/(\w+)\s*=\s*"(.*?)"/';

        preg_match_all($regex, $text, $matches);

        $coursesinfos = array();
        for ($i = 0; $i < count($matches[1]); $i++)
            $coursesinfos[$matches[1][$i]] = $matches[2][$i];

        if (strpos($text, '[coursesinfos') !== false) {

            $lang = current_language();
            $langs = "";

            if(@$coursesinfos['langs']!="")
                $langs = $coursesinfos['langs'];
            else
                $langs = $coursesinfos['langs_'.$lang];

            $html .= '<div class="container" id="course-infos">';

            $html .= '<div class="row d-none d-lg-flex">';
            $html .= '<div class="col-md-4"><span class="sr-only">' . get_string('authors', 'filter_mirocoursesinfos') . ' </span><span class="author-'.$lang.' bigicons"><strong>' . $coursesinfos['author'] . '</strong></span></div>';
            $html .= '<div class="col-md-4"><span class="sr-only">' . get_string('time', 'filter_mirocoursesinfos') . ' </span><span class="time-'.$lang.' bigicons"><strong>' . $coursesinfos['time'] . '</strong></span></div>';
            $html .= '<div class="col-md-4"><span class="sr-only">' . get_string('languages', 'filter_mirocoursesinfos') . ' </span><span class="langa-'.$lang.' bigicons"><strong>' . $langs . '</strong></span></div>';
            $html .= '</div>';

            $html .= '<div class="row d-lg-none">';
            $html .= '<div class="col-lg-4"><span class="authori smallicons">' . get_string('authors', 'filter_mirocoursesinfos') . ' <strong>' . $coursesinfos['author'] . '</strong></span></div>';
            $html .= '<div class="col-lg-4"><span class="timei smallicons">' . get_string('time', 'filter_mirocoursesinfos') . ' <strong>' . $coursesinfos['time'] . '</strong></span></div>';
            $html .= '<div class="col-lg-4"><span class="langai smallicons">' . get_string('languages', 'filter_mirocoursesinfos').' <strong>' . $langs . '</strong></span></div>';
            $html .= '</div>';

            $html .= '</div>';

        } else {

            $html .= '<h2 id="course-title">' . str_replace('|', '<br>', $coursesinfos['title']) . '</h2>';
        }

        return $html;
    }
}
