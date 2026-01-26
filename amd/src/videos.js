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
 * YouTube Videos Block
 *
 * @module     block_youtube_videos/videos
 * @copyright  2024
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define(['jquery'], function($) {
    // Store instances per swiperid to handle multiple block instances
    var swiperInstances = {};
    var allVideos = {};
    var currentVideos = {};

    return {
        init: function(swiperid, prevButton, nextButton, searchInputId, videosdata) {
            // Store all videos data per instance
            allVideos[swiperid] = videosdata.videos || [];
            currentVideos[swiperid] = (allVideos[swiperid] || []).slice();

            // Wait for Swiper to be loaded
            if (typeof window.Swiper === 'undefined' || !window.Swiper) {
                var self = this;
                setTimeout(function() {
                    self.init(swiperid, prevButton, nextButton, searchInputId, videosdata);
                }, 100);
                return;
            }

            var Swiper = window.Swiper;

            // Initialize Swiper
            var swiperEl = document.getElementById(swiperid);
            if (!swiperEl) {
                return;
            }

            // Destroy existing Swiper instance for this ID if it exists
            if (swiperInstances[swiperid]) {
                try {
                    swiperInstances[swiperid].destroy(true, true);
                } catch (e) {
                    // Ignore errors during destruction
                }
                swiperInstances[swiperid] = null;
            }

            // Initialize new Swiper instance
            try {
                swiperInstances[swiperid] = new Swiper('#' + swiperid, {
                    spaceBetween: 30,
                    centeredSlides: true,
                    navigation: {
                        nextEl: nextButton,
                        prevEl: prevButton,
                    },
                    slidesPerView: 1,
                    loop: false
                });
            } catch (e) {
                console.error('Error initializing Swiper:', e);
                return;
            }

            // Search functionality
            var searchInput = document.querySelector(searchInputId);
            if (searchInput) {
                $(searchInput).on('input', function() {
                    var searchTerm = $(this).val().toLowerCase().trim();
                    filterVideos(searchTerm);
                });
            }

            // Video play button click handlers
            $(swiperEl).on('click', '.video-play-btn', function(e) {
                e.preventDefault();
                var videoUrl = $(this).data('video-url');
                if (videoUrl) {
                    // Open video URL in new tab/window
                    window.open(videoUrl, '_blank');
                }
            });

            function filterVideos(searchTerm) {
                if (!searchTerm) {
                    currentVideos[swiperid] = (allVideos[swiperid] || []).slice();
                } else {
                    currentVideos[swiperid] = (allVideos[swiperid] || []).filter(function(video) {
                        var titleMatch = video.title.toLowerCase().indexOf(searchTerm) !== -1;
                        var descMatch = video.description.toLowerCase().indexOf(searchTerm) !== -1;
                        return titleMatch || descMatch;
                    });
                }

                // Regenerate slides (this would require re-rendering the template)
                // For now, we'll just update the display
                updateSwiperSlides();
            }

            function updateSwiperSlides() {
                // Group videos into slides (3 per slide)
                var itemsPerSlide = 3;
                var videos = currentVideos[swiperid] || [];
                var slides = [];
                for (var i = 0; i < videos.length; i += itemsPerSlide) {
                    slides.push(videos.slice(i, i + itemsPerSlide));
                }

                // Rebuild Swiper content
                var wrapper = swiperEl.querySelector('.swiper-wrapper');
                if (!wrapper) {
                    return;
                }

                wrapper.innerHTML = '';

                slides.forEach(function(slide) {
                    var slideEl = document.createElement('div');
                    slideEl.className = 'swiper-slide';
                    
                    slide.forEach(function(video) {
                        var videoItem = createVideoItem(video);
                        slideEl.appendChild(videoItem);
                    });

                    wrapper.appendChild(slideEl);
                });

                // Update Swiper
                if (swiperInstances[swiperid]) {
                    swiperInstances[swiperid].update();
                }
            }

            function createVideoItem(video) {
                var item = document.createElement('div');
                item.className = 'd-flex align-items-center justify-content-between mb-3 gap3';
                
                var imageurls = videosdata.imageurls || {
                    thumbnail_base: '',
                    play_button: ''
                };

                item.innerHTML = '<figure class="mb-0 d-flex align-items-center gap-3">' +
                    '<img src="' + imageurls.thumbnail_base + video.thumbnail + '" alt="' + video.title + '" style="max-width: 100px; height: auto;">' +
                    '<figcaption>' +
                    '<h6 class="text-black mb-2">' + video.title + '</h6>' +
                    '<p class="mb-0 font-Regular">' + video.description + '</p>' +
                    '</figcaption>' +
                    '</figure>' +
                    '<div>' +
                    '<button class="btn video-play-btn" type="button" data-video-url="' + video.url + '">' +
                    '<img src="' + imageurls.play_button + '" alt="Play" height="35">' +
                    '</button>' +
                    '</div>';

                return item;
            }
        }
    };
});
