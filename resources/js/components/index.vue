<!-- @format -->

<template>
	<div class="min-h-screen bg-gray-100 p-6">
        <div class="mb-6">
			<h2 class="font-bold text-xl">Laporan Harian</h2>
			<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
				<div class="bg-white p-4 rounded-lg shadow-md">
					<h3 class="font-semibold">Total Tindakan Infus 10</h3>
					<p> {{  datas.infusD }}</p>
				</div>
				<div class="bg-white p-4 rounded-lg shadow-md">
					<h3 class="font-semibold">Total Tindakan Perawat</h3>
					<p> {{  datas.perawatD }}</p>
				</div>
				<div class="bg-white p-4 rounded-lg shadow-md">
					<h3 class="font-semibold">Total Tindakan</h3>
					<p> {{  datas.cancel }}</p>
				</div>
			</div>
		</div>
		<!-- Grid untuk Menampilkan Ruangan dan Bed -->
		<div
			class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-7 gap-6">
			<div
				v-for="(room, roomIndex) in rooms"
				:key="roomIndex"
				class="bg-white rounded-lg shadow-lg p-4">
				<div class="text-center mb-4">
					<h1 class="font-bold text-xl text-gray-800">Ruang KRIS</h1>
					<p class="text-xl font-bold">{{ roomIndex + 1 }}</p>
				</div>

				<!-- Bed di setiap ruangan -->
				<div class="grid grid-cols-1 gap-4 justify-center">
					<div
						v-for="(bed, bedIndex) in room.beds"
						:key="bedIndex"
						:class="[
							'bg-gray-200',
							bed.status,
							bed.isBlinking ? 'animate-pulse' : '', // Mengaktifkan animasi berkedip saat bed dalam status infus atau emergency
							bed.status === 'infus' ? 'bg-green-500' : '', // Warna hijau untuk infus
							bed.status === 'perawat' ? 'bg-orange-500' : '', // Warna orange untuk perawat
							bed.status === 'emergency' ? 'bg-red-500' : '', // Warna merah untuk emergency
						]">
						<div
							class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center">
							<p class="text-white font-bold">Bed {{ bedIndex === 0 ? 'A' : 'B' }}</p>
						</div>
						<div class="mt-2 flex justify-around gap-4">
							<button
								class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-2 rounded-lg">
								Infus
							</button>
							<button
								class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-2 rounded-lg">
								Perawat
							</button>
						</div>
					</div>
				</div>

				<!-- Tombol Emergency dan Cancel untuk Setiap Ruangan -->
				<!-- <div class="mt-4 flex justify-around">
					<button
						@click="handleEmergency(roomIndex)"
						class="bg-red-600 hover:bg-red-700 text-white py-1 px-2 rounded-lg">
						Emergency
					</button>
					<button
						@click="handleCancel(roomIndex)"
						class="bg-gray-400 hover:bg-gray-500 text-white py-1 px-2 rounded-lg">
						Cancel
					</button>
				</div> -->
			</div>
		</div>

	</div>
</template>
<script setup>
	import { onMounted, ref, watch } from 'vue';
	import axios from 'axios';

	const peringatan = ref('');

	const datas = ref([]);

	watch(peringatan, (newPesan, oldPesan) => {
		// console.log(`Pesan berubah dari: ${oldPesan} menjadi: ${newPesan.status}`);
		if (newPesan.status == 'infus') {
			handleAction('infus', newPesan.ruang - 1, newPesan.bed - 1);
		} else if (newPesan.status == 'perawat') {
			handleAction('perawat', newPesan.ruang - 1, newPesan.bed - 1);
		} else if (newPesan.status == 'cancel') {
			handleCancel(newPesan.ruang - 1);
		} else if (newPesan.status == 'emergency') {
			handleEmergency(newPesan.ruang - 1);
		}
	});

	// Struktur data untuk ruangan dan bed
	const rooms = ref([
		{
			beds: [
				{ status: '', name: 'Bed A', isBlinking: false, sound: null },
				{ status: '', name: 'Bed B', isBlinking: false, sound: null },
			],
		},
		{
			beds: [
				{ status: '', name: 'Bed A', isBlinking: false, sound: null },
				{ status: '', name: 'Bed B', isBlinking: false, sound: null },
			],
		},
		{
			beds: [
				{ status: '', name: 'Bed A', isBlinking: false, sound: null },
				{ status: '', name: 'Bed B', isBlinking: false, sound: null },
			],
		},
		{
			beds: [
				{ status: '', name: 'Bed A', isBlinking: false, sound: null },
				{ status: '', name: 'Bed B', isBlinking: false, sound: null },
			],
		},
		{
			beds: [
				{ status: '', name: 'Bed A', isBlinking: false, sound: null },
				{ status: '', name: 'Bed B', isBlinking: false, sound: null },
			],
		},
		{
			beds: [
				{ status: '', name: 'Bed A', isBlinking: false, sound: null },
				{ status: '', name: 'Bed B', isBlinking: false, sound: null },
			],
		},
		{
			beds: [
				{ status: '', name: 'Bed A', isBlinking: false, sound: null },
				{ status: '', name: 'Bed B', isBlinking: false, sound: null },
			],
		},
		{
			beds: [
				{ status: '', name: 'Bed A', isBlinking: false, sound: null },
				{ status: '', name: 'Bed B', isBlinking: false, sound: null },
			],
		},
		{
			beds: [
				{ status: '', name: 'Bed A', isBlinking: false, sound: null },
				{ status: '', name: 'Bed B', isBlinking: false, sound: null },
			],
		},
		{
			beds: [
				{ status: '', name: 'Bed A', isBlinking: false, sound: null },
				{ status: '', name: 'Bed B', isBlinking: false, sound: null },
			],
		},
		{
			beds: [
				{ status: '', name: 'Bed A', isBlinking: false, sound: null },
				{ status: '', name: 'Bed B', isBlinking: false, sound: null },
			],
		},
		{
			beds: [
				{ status: '', name: 'Bed A', isBlinking: false, sound: null },
				{ status: '', name: 'Bed B', isBlinking: false, sound: null },
			],
		},
		{
			beds: [
				{ status: '', name: 'Bed A', isBlinking: false, sound: null },
				{ status: '', name: 'Bed B', isBlinking: false, sound: null },
			],
		},
		{
			beds: [
				{ status: '', name: 'Bed A', isBlinking: false, sound: null },
				{ status: '', name: 'Bed B', isBlinking: false, sound: null },
			],
		},
	]);

	const emergencySound = ref(null);
	const perawatSound = ref(null);
	const infusSound = ref(null);
	const doorSound = ref(null);

	onMounted(() => {
		window.Echo.channel('delivery').listen('PackageSent', (event) => {
			peringatan.value = event;
			// console.log(event);
		});
        // getDatas()
	});

	// Fungsi untuk menangani aksi Infus dan Perawat
	function handleAction(action, roomIndex, bedIndex) {
		// console.log(`${action} for Room ${roomIndex + 1}, Bed ${bedIndex + 1}`);

		// Hentikan semua suara yang sedang diputar
		stopAllSounds();

		// Update status bed berdasarkan aksi yang dilakukan
		if (action === 'infus') {
			rooms.value[roomIndex].beds[bedIndex].status = 'infus'; // Ganti warna bed menjadi hijau (infus)
			startBlinking(roomIndex, bedIndex); // Start blinking when infus
			playInfus(roomIndex, bedIndex);
		} else if (action === 'perawat') {
			rooms.value[roomIndex].beds[bedIndex].status = 'perawat'; // Ganti warna bed menjadi orange (perawat)
			startBlinking(roomIndex, bedIndex); // Start blinking when infus
			playPerawat(roomIndex, bedIndex);
		}
	}

	// Fungsi untuk Emergency untuk setiap ruangan
	function handleEmergency(roomIndex) {
		// console.log(`Emergency for Room ${roomIndex + 1}`);
		stopAllSounds(); // Hentikan semua suara yang sedang diputar
		startBlinking(roomIndex, null); // Start blinking for the whole room
		playEmergency(); // Mainkan suara emergency
		// getDatas();
	}

	// Fungsi untuk Cancel untuk setiap ruangan
	function handleCancel(roomIndex) {
		// console.log(`Cancel for Room ${roomIndex + 1}`);
		stopAllSounds(); // Hentikan semua suara yang sedang diputar
		stopBlinking(roomIndex); // Stop blinking for the room
		// getDatas();
	}

	// Fungsi untuk berhenti berkedip pada seluruh bed dalam ruangan
	function stopBlinking(roomIndex) {
		rooms.value[roomIndex].beds.forEach((bed) => {
			bed.isBlinking = false;
			bed.status = ''; // Reset status jika diperlukan
		});
	}

	// Fungsi untuk memulai berkedip
	function startBlinking(roomIndex, bedIndex = null) {
		if (bedIndex !== null) {
			rooms.value[roomIndex].beds[bedIndex].isBlinking = true; // Set the bed to blink
		} else {
			// Make all beds in the room blink if no specific bed is selected
			rooms.value[roomIndex].beds.forEach((bed) => {
				bed.isBlinking = true;
			});
		}
	}

	function stopAllSounds() {
		if (emergencySound.value) {
			emergencySound.value.pause();
			emergencySound.value.currentTime = 0;
		}
		if (perawatSound.value) {
			perawatSound.value.pause();
			perawatSound.value.currentTime = 0;
		}
		if (infusSound.value) {
			infusSound.value.pause();
			infusSound.value.currentTime = 0;
		}
		if (doorSound.value) {
			infusSound.value.pause();
			infusSound.value.currentTime = 0;
		}
	}

	// Function to play emergency sound
	function playEmergency() {
		if (!emergencySound.value || emergencySound.value.paused) {
			// getDatas();
			emergencySound.value = new Audio('../../../audio/e1.mp3');
			emergencySound.value.loop = true;
			emergencySound.value.play().catch((err) => {
				console.error('Error playing emergency sound:', err);
			});
		}
	}

	// Function to play perawat sound
	function playPerawat(roomIndex, bedIndex) {
		// getDatas();
		doorSound.value = new Audio('../../../audio/bell.mp3');
		doorSound.value.play();
		setTimeout(() => {
			perawatSound.value = new Audio(
				`../../../audio/perawat_${roomIndex + 1}_${bedIndex + 1}.mp3`
			);
			perawatSound.value.loop = true;
			perawatSound.value.play().catch((err) => {
				console.error('Error playing perawat sound:', err);
			});
		}, 1000);
	}

	async function getDatas() {
		await axios.get('/counting').then((res) => {
			datas.value = res.data;
		});
	}

	// Function to play infus sound
	function playInfus(roomIndex, bedIndex) {
		// getDatas();
		doorSound.value = new Audio('../../../audio/bell.mp3');
		doorSound.value.play();
		setTimeout(() => {
			infusSound.value = new Audio(
				`../../../audio/infus_${roomIndex + 1}_${bedIndex + 1}.mp3`
			);
			infusSound.value.loop = true;
			infusSound.value.play().catch((err) => {
				console.error('Error playing infus sound:', err);
			});
		}, 1000);
	}
</script>
<style scoped>
	/* CSS untuk animasi berkedip */
	.animate-pulse {
		animation: pulse 1s infinite;
	}

	@keyframes pulse {
		0% {
			opacity: 1;
		}
		50% {
			opacity: 0.5;
		}
		100% {
			opacity: 1;
		}
	}

	/* Berkedip dengan warna hijau (Infus) */
	.bg-green-500.animate-pulse {
		background-color: #48bb78; /* Warna hijau untuk infus */
	}

	/* Berkedip dengan warna orange (Perawat) */
	.bg-orange-500.animate-pulse {
		background-color: #f6ad55; /* Warna orange untuk perawat */
	}

	/* Berkedip dengan warna merah (Emergency) */
	.bg-red-500.animate-pulse {
		background-color: #e53e3e; /* Warna merah untuk emergency */
	}
</style>
