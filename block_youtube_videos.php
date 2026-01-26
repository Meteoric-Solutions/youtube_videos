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
 * YouTube Videos block
 *
 * @package    block_youtube_videos
 * @copyright  2024
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class block_youtube_videos extends block_base {

    public function init() {
        $this->title = get_string('pluginname', 'block_youtube_videos');
    }

    public function has_config() {
        return false;
    }

    public function instance_allow_multiple() {
        return false;
    }

    public function applicable_formats() {
        return array(
            'site' => true,
            'course' => true,
            'my' => true
        );
    }

    public function get_content() {
        global $OUTPUT, $CFG;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->text = '';
        $this->content->footer = '';

        // Static video data - can be replaced with API/database later
        $videosdata = [
            'videos' => [
                [
                    'id' => 1,
                    'thumbnail' => 'Rectangle163.png',
                    'title' => 'Introduction to Leadership Skills',
                    'description' => 'Learn the fundamental principles of effective leadership and team management.',
                    'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'
                ],
                [
                    'id' => 2,
                    'thumbnail' => 'Rectangle164.png',
                    'title' => 'Communication Excellence',
                    'description' => 'Master the art of professional communication in the workplace.',
                    'url' => 'https://www.youtube.com/watch?v=jNQXAC9IVRw'
                ],
                [
                    'id' => 3,
                    'thumbnail' => 'Rectangle165.png',
                    'title' => 'Time Management Strategies',
                    'description' => 'Discover proven techniques to maximize productivity and achieve your goals.',
                    'url' => 'https://www.youtube.com/watch?v=9bZkp7q19f0'
                ],
                [
                    'id' => 4,
                    'thumbnail' => 'Rectangle163.png',
                    'title' => 'Digital Transformation Essentials',
                    'description' => 'Understanding how technology is reshaping modern business practices.',
                    'url' => 'https://www.youtube.com/watch?v=kJQP7kiw5Fk'
                ],
                [
                    'id' => 5,
                    'thumbnail' => 'Rectangle164.png',
                    'title' => 'Customer Service Excellence',
                    'description' => 'Building lasting relationships through exceptional customer experience.',
                    'url' => 'https://www.youtube.com/watch?v=L_jWHffIx5E'
                ],
                [
                    'id' => 6,
                    'thumbnail' => 'Rectangle165.png',
                    'title' => 'Innovation and Creativity',
                    'description' => 'Fostering a culture of innovation and creative problem-solving.',
                    'url' => 'https://www.youtube.com/watch?v=fJ9rUzIMcZQ'
                ]
            ],
            'instanceid' => $this->instance->id
        ];

        // Determine plugin directory name
        $blockname = $this->name();
        $pluginpath1 = $CFG->dirroot . '/blocks/' . $blockname;
        $pluginpath2 = $CFG->dirroot . '/blocks/block_' . $blockname;
        
        if (file_exists($pluginpath1)) {
            $pluginname = $blockname;
        } else if (file_exists($pluginpath2)) {
            $pluginname = 'block_' . $blockname;
        } else {
            $pluginname = 'block_youtube_videos';
        }

        // Image URLs - Add to videosdata for JavaScript
        $videosdata['imageurls'] = [
            'play_button' => $CFG->wwwroot . '/blocks/' . $pluginname . '/pix/Group123.png',
            'thumbnail_base' => $CFG->wwwroot . '/blocks/' . $pluginname . '/pix/'
        ];
        
        // Image URLs for template
        $imageurls = $videosdata['imageurls'];

        // Prepare video slides (3 videos per slide)
        $videos = $videosdata['videos'];
        $slides = [];
        $itemsPerSlide = 3;
        for ($i = 0; $i < count($videos); $i += $itemsPerSlide) {
            $slide = array_slice($videos, $i, $itemsPerSlide);
            // Add imageurls to each video in slide for template access
            foreach ($slide as &$video) {
                $video['imageurls'] = $imageurls;
            }
            unset($video); // Break reference
            $slides[] = $slide;
        }

        // Render template
        $templatecontext = (object) [
            'swiperid' => 'swiper_youtube_' . $this->instance->id,
            'buttonprevclass' => 'button-prev-youtube-' . $this->instance->id,
            'buttonnextclass' => 'button-next-youtube-' . $this->instance->id,
            'searchinputid' => 'search-videos-' . $this->instance->id,
            'slides' => $slides,
            'videos' => $videos,
            'videosdata' => json_encode($videosdata),
            'imageurls' => (object) $imageurls
        ];

        $this->content->text = $OUTPUT->render_from_template('block_youtube_videos/videos', $templatecontext);

        // Load Bootstrap Icons CSS
        $bootstrapiconscss = new moodle_url('/blocks/' . $pluginname . '/thirdparty/bootstrap-icons/bootstrap-icons.css');
        $this->page->requires->css($bootstrapiconscss);

        // Load Swiper CSS
        $swipercss = new moodle_url('/blocks/' . $pluginname . '/thirdparty/swiper/swiper-bundle.min.css');
        $this->page->requires->css($swipercss);

        // Load Swiper JS library (local file)
        $swiperjs = new moodle_url('/blocks/' . $pluginname . '/thirdparty/swiper/swiper-bundle.min.js');
        $this->page->requires->js($swiperjs, true);

        // Use js_init_code to ensure Swiper is loaded before calling AMD module
        $swiperjsurl = $swiperjs->out(false);
        $initcode = "
            (function() {
                function initSwiperModule() {
                    if (typeof window.Swiper !== 'undefined' && window.Swiper) {
                        require(['block_youtube_videos/videos'], function(videos) {
                            videos.init(
                                'swiper_youtube_" . $this->instance->id . "',
                                '.button-prev-youtube-" . $this->instance->id . "',
                                '.button-next-youtube-" . $this->instance->id . "',
                                '#search-videos-" . $this->instance->id . "',
                                " . json_encode($videosdata) . "
                            );
                        });
                    } else {
                        setTimeout(initSwiperModule, 100);
                    }
                }
                initSwiperModule();
            })();
        ";
        $this->page->requires->js_init_code($initcode);

        return $this->content;
    }

    public function specialization() {
        if (isset($this->config->title)) {
            $this->title = $this->config->title;
        } else {
            $this->title = get_string('pluginname', 'block_youtube_videos');
        }
    }
}
