// Fungsi untuk menginisialisasi pemutar audio
function initAudioPlayer() {
    const audioPlayer = document.createElement('audio');
    audioPlayer.style.display = 'none';
    document.body.appendChild(audioPlayer);
    
    let currentButton = null;
    let currentSongId = null;

    // Fungsi untuk menangani play/pause
    function handlePlayPause(button, songUrl, songId, userId) {
        const icon = button.querySelector('i');
        
        // Jika lagu yang sama diklik
        if (currentSongId === songId) {
            if (audioPlayer.paused) {
                audioPlayer.play();
                icon.classList.replace('bi-play-circle-fill', 'bi-pause-circle-fill');
            } else {
                audioPlayer.pause();
                icon.classList.replace('bi-pause-circle-fill', 'bi-play-circle-fill');
            }
            return;
        }

        // Jika lagu baru diklik
        if (currentButton) {
            const prevIcon = currentButton.querySelector('i');
            prevIcon.classList.replace('bi-pause-circle-fill', 'bi-play-circle-fill');
        }

        audioPlayer.src = songUrl;
        audioPlayer.play();
        icon.classList.replace('bi-play-circle-fill', 'bi-pause-circle-fill');
        
        // Simpan riwayat pemutaran
        savePlayHistory(songId, userId);
        
        currentButton = button;
        currentSongId = songId;
    }

    // Event ketika audio selesai
    audioPlayer.addEventListener('ended', () => {
        if (currentButton) {
            const icon = currentButton.querySelector('i');
            icon.classList.replace('bi-pause-circle-fill', 'bi-play-circle-fill');
        }
        currentSongId = null;
        currentButton = null;
    });

    return {
        handlePlayPause
    };
}

// Fungsi untuk menyimpan riwayat pemutaran
function savePlayHistory(songId, userId) {
    if (!songId || !userId) return;
    
    fetch("save_play_history.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `id_lagu=${songId}&id_pengguna=${userId}`
    }).catch(err => console.error('Gagal menyimpan riwayat:', err));
}

// Fungsi untuk menangani favorit
function initFavoriteButtons() {
    document.querySelectorAll('.favorite-btn').forEach(button => {
        button.addEventListener('click', function() {
            const songId = this.dataset.songId;
            const icon = this.querySelector('i');
            
            fetch("save_favorite.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `song_id=${songId}&user_id=${this.dataset.userId}`
            })
            .then(response => {
                if (!response.ok) throw new Error("Network response was not ok");
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    icon.classList.toggle('bi-heart');
                    icon.classList.toggle('bi-heart-fill');
                    icon.classList.toggle('text-danger');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
}

// Inisialisasi ketika DOM siap
document.addEventListener('DOMContentLoaded', () => {
    const audioPlayer = initAudioPlayer();
    const userId = document.body.dataset.userId;
    
    // Atur event listener untuk tombol play
    document.querySelectorAll('.playPauseBtn').forEach(button => {
        button.addEventListener('click', function() {
            audioPlayer.handlePlayPause(
                this,
                this.dataset.songUrl,
                this.dataset.songId,
                userId
            );
        });
    });
    
    // Inisialisasi tombol favorit
    initFavoriteButtons();
});