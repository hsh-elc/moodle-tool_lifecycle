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
 * Offers the possibility to add or modify a step instance.
 *
 * @package    tool_cleanupcourses
 * @copyright  2017 Tobias Reischmann WWU
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace tool_cleanupcourses;

use tool_cleanupcourses\entity\step_subplugin;
use tool_cleanupcourses\manager\step_manager;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');

/**
 * Provides a form to modify a step instance
 */
class form_step_instance extends \moodleform {


    /**
     * @var step_subplugin
     */
    public $step;

    /**
     * Constructor
     * @param string $url
     * @param step_subplugin $step
     */
    public function __construct($url, $step) {
        parent::__construct($url);
        $this->step = $step;
    }

    /**
     * Defines forms elements
     */
    public function definition() {
        $mform = $this->_form;

        $mform->addElement('hidden', 'id'); // Save the record's id.
        $mform->setType('id', PARAM_TEXT);

        $elementname = 'instancename';
        $mform->addElement('text', $elementname, get_string('step_instancename', 'tool_cleanupcourses'));
        $mform->setType($elementname, PARAM_TEXT);

        $stepmanager = new step_manager();
        $elementname = 'name';
        $mform->addElement('select', $elementname, get_string('step_name', 'tool_cleanupcourses'),
            $stepmanager->get_step_types());
        $mform->setType($elementname, PARAM_TEXT);

        $elementname = 'followedby';
        $mform->addElement('select', $elementname, get_string('step_followedby', 'tool_cleanupcourses'),
            $stepmanager->get_step_instances());
        $mform->setType($elementname, PARAM_TEXT);

        $this->add_action_buttons();
    }

    /**
     * Defines forms elements
     */
    public function definition_after_data() {
        $mform = $this->_form;

        if ($this->step) {
            $mform->setDefault('id', $this->step->id);
            $mform->setDefault('instancename', $this->step->instancename);
            $mform->setDefault('name', $this->step->name);
            $mform->setDefault('followedby', $this->step->followedby);
        } else {
            $mform->setDefault('id', '');
        }
    }

}