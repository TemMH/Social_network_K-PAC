document.addEventListener("DOMContentLoaded", function() {
    const videos = document.querySelectorAll("video");
    const theaterBtns = document.querySelectorAll(".theater-btn");
    const shortVideoRamaScroll = document.querySelector(".shortvideo_rama_scroll");

    function toggleFullScreen() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            }
        }
    }

    let speedChanged = false;



    document.addEventListener("keydown", function(event) {
        if (event.keyCode === 32) {
            event.preventDefault();
            const activeVideo = document.querySelector(".shortvideo_rama.active video");
            if (activeVideo) {
                if (activeVideo.paused) {
                    activeVideo.play();
                } else {
                    activeVideo.pause();
                }
            }
        }
    });

    document.addEventListener("fullscreenchange", function() {
        if (!document.fullscreenElement) {
            shortVideoRamaScroll.classList.remove("theater");
        }
    });

    const savedVolume = localStorage.getItem("savedVolume");
    const initialVolume = savedVolume !== null ? parseFloat(savedVolume) : 1;

    videos.forEach(function(video) {
        const playPauseBtn = video.parentElement.querySelector(".play-pause-btn");
        const volumeBtn = video.parentElement.querySelector(".mute-btn");
        const volumeSlider = video.parentElement.querySelector(".volume-slider");
        const currentTimeDisplay = video.parentElement.querySelector(".current-time");
        const totalTimeDisplay = video.parentElement.querySelector(".total-time");
        const timeline = video.parentElement.querySelector(".timeline");
        const speedBtn = video.parentElement.querySelector(".speed-btn");
        const thumbIndicator = video.parentElement.querySelector(".thumb-indicator");

        document.addEventListener("keydown", function(event) {
            if (event.target.tagName.toLowerCase() !== 'input' && event.target.tagName
                .toLowerCase() !== 'textarea') {
                const activeVideo = document.querySelector(".shortvideo_rama.active video");

                switch (event.keyCode) {

                    case 37: // Стрелка влево
                        if (activeVideo && activeVideo.currentTime >= 1) {
                            activeVideo.currentTime -= 1;
                        }
                        break;
                    case 39: // Стрелка вправо
                        const rightActiveVideo = document.querySelector(
                            ".shortvideo_rama.active video");
                        if (rightActiveVideo) {
                            if (!speedChanged) {
                                changePlaybackSpeed(rightActiveVideo, rightActiveVideo
                                    .parentElement.querySelector(".speed-btn"));
                                speedChanged =
                                    true;
                            }
                        }
                        break;
                    case 77: // Клавиша M
                        video.muted = !video.muted;
                        break;
                }
            }
        });



        theaterBtns.forEach(function(theaterBtn) {
            theaterBtn.addEventListener("click", toggleTheaterAndFullScreen);
        });

        document.addEventListener("keyup", function(event) {
            if (event.keyCode ===
                39) {
                speedChanged = false;
            }
        });
        video.volume = initialVolume;
        volumeSlider.value = initialVolume;

        playPauseBtn.addEventListener("click", function() {
            if (video.paused) {
                video.play();
            } else {
                video.pause();
            }
        });



        volumeBtn.addEventListener("click", function() {
            if (video.muted) {
                video.muted = false;
                volumeSlider.value = initialVolume;
            } else {
                video.muted = true;
                volumeSlider.value = 0;
            }
        });

        volumeSlider.addEventListener("input", function() {
            video.volume = volumeSlider.value;
            localStorage.setItem("savedVolume", volumeSlider.value);
        });

        video.addEventListener("timeupdate", function() {
            currentTimeDisplay.textContent = formatTime(video.currentTime);
            totalTimeDisplay.textContent = formatTime(video.duration);

            const progress = video.currentTime / video.duration * 100;
            thumbIndicator.style.left = `${progress}%`;
        });

        function formatTime(time) {
            const minutes = Math.floor(time / 60);
            const seconds = Math.floor(time % 60);
            return `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        }

        speedBtn.addEventListener("click", function() {
            changePlaybackSpeed(video, speedBtn);
        });
    });
});


function changePlaybackSpeed(video, speedBtn) {
    let newPlaybackRate = video.playbackRate + 0.25;
    if (newPlaybackRate > 2) newPlaybackRate = 0.25;
    video.playbackRate = newPlaybackRate;
    speedBtn.textContent = `${newPlaybackRate}x`;
}


document.addEventListener("DOMContentLoaded", function() {
    const videos = document.querySelectorAll("video");

    function updateAddressBar(videoId) {
        window.history.replaceState(null, null, `?videoId=${videoId}`);
    }

    const options = {
        root: null,
        rootMargin: '0px',
        threshold: 0.5
    };

    function handleIntersection(entries, observer) {
        entries.forEach(entry => {
            const video = entry.target;
            const shortVideoRama = video.closest('.shortvideo_rama');
            if (shortVideoRama) {
                if (entry.isIntersecting) {

                    const videoId = shortVideoRama.dataset.videoId;
                    updateVideoViews(videoId);

                    video.play();
                    shortVideoRama.classList.add('active');
                    updateAddressBar(videoId);
                } else {
                    video.pause();
                    shortVideoRama.classList.remove('active');
                }
            }
        });
    }

    function updateVideoViews(videoId) {
        fetch(`/view/video/${videoId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log(data);
            })
            .catch(error => {
                console.error('There was a problem with your fetch operation:', error);
            });
    }


    const observer = new IntersectionObserver(handleIntersection, options);

    videos.forEach(video => {
        observer.observe(video);
    });




});


