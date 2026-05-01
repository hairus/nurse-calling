<!-- @format -->
<template>
    <div class="nurse-console min-h-screen text-slate-950 dark:text-white">
        <header class="sticky top-0 z-40 border-b border-white/70 bg-white/95 dark:border-white/10 dark:bg-[#0b1020]/95">
            <div class="mx-auto flex max-w-screen-2xl flex-wrap items-center justify-between gap-4 px-4 py-3 sm:px-6">
                <div class="flex min-w-0 items-center gap-3">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-teal-600 text-white shadow-lg shadow-teal-600/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-teal-700 dark:text-teal-300">Rumah Sakit Islam</p>
                        <h1 class="truncate text-xl font-black leading-tight text-slate-950 dark:text-white sm:text-2xl">
                            RSI Garam Kalianget
                        </h1>
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-end gap-2 sm:gap-3">
                    <div :class="['flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-bold ring-1', priorityBadgeClass]">
                        <span :class="['h-2.5 w-2.5 rounded-full', priorityDotClass]"></span>
                        {{ priorityLabel }}
                    </div>

                    <button @click="toggleDark"
                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100 text-slate-700 ring-1 ring-slate-200 transition hover:bg-white dark:bg-white/10 dark:text-slate-200 dark:ring-white/10 dark:hover:bg-white/15"
                        :title="isDark ? 'Mode terang' : 'Mode gelap'">
                        <svg v-if="isDark" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-300"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="4" />
                            <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41" />
                        </svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" />
                        </svg>
                    </button>

                    <div class="min-w-[132px] rounded-lg bg-slate-950 px-3 py-2 text-right text-white shadow-lg shadow-slate-950/15 dark:bg-white dark:text-slate-950">
                        <p class="font-mono text-xl font-black leading-none tabular-nums">{{ currentTime }}</p>
                        <p class="mt-1 text-[10px] font-semibold text-slate-300 dark:text-slate-500">{{ currentDate }}</p>
                    </div>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-screen-2xl px-4 py-5 sm:px-6">
            <Transition name="banner">
                <button v-if="!audioUnlocked" @click="unlockAudio"
                    class="mb-4 flex w-full items-center gap-3 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-left shadow-sm transition hover:border-amber-300 hover:bg-amber-100 dark:border-amber-500/20 dark:bg-amber-500/10 dark:hover:bg-amber-500/15">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-amber-500 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5" />
                            <path d="M16 8.5a5 5 0 0 1 0 7" />
                        </svg>
                    </span>
                    <span class="min-w-0">
                        <span class="block text-sm font-black text-amber-900 dark:text-amber-100">Aktifkan audio</span>
                        <span class="block text-xs font-medium text-amber-700 dark:text-amber-300">Diperlukan sekali agar alarm dapat berbunyi.</span>
                    </span>
                </button>
            </Transition>

            <section class="mb-5 grid gap-3 lg:grid-cols-[1fr_auto]">
                <div :class="['rounded-lg border p-4 shadow-sm', priorityPanelClass]">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.18em] opacity-70">Status Prioritas</p>
                            <p class="mt-1 text-3xl font-black leading-tight">{{ priorityHeadline }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-center sm:grid-cols-4">
                            <div class="rounded-lg bg-white/70 px-3 py-2 ring-1 ring-black/5 dark:bg-black/20 dark:ring-white/10">
                                <p class="text-2xl font-black tabular-nums">{{ activeRoomsCount }}</p>
                                <p class="text-[10px] font-bold uppercase tracking-wide opacity-70">Ruang</p>
                            </div>
                            <div class="rounded-lg bg-white/70 px-3 py-2 ring-1 ring-black/5 dark:bg-black/20 dark:ring-white/10">
                                <p class="text-2xl font-black tabular-nums">{{ activeBedsCount }}</p>
                                <p class="text-[10px] font-bold uppercase tracking-wide opacity-70">Bed</p>
                            </div>
                            <div class="rounded-lg bg-white/70 px-3 py-2 ring-1 ring-black/5 dark:bg-black/20 dark:ring-white/10">
                                <p class="text-2xl font-black tabular-nums">{{ activeInfusCount }}</p>
                                <p class="text-[10px] font-bold uppercase tracking-wide opacity-70">Infus</p>
                            </div>
                            <div class="rounded-lg bg-white/70 px-3 py-2 ring-1 ring-black/5 dark:bg-black/20 dark:ring-white/10">
                                <p class="text-2xl font-black tabular-nums">{{ emergencyRoomsCount }}</p>
                                <p class="text-[10px] font-bold uppercase tracking-wide opacity-70">Darurat</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 border-t border-black/10 pt-3 dark:border-white/10">
                        <div class="mb-2 flex items-center justify-between gap-2">
                            <p class="text-xs font-black uppercase tracking-[0.18em] opacity-70">Log Panggilan Terbaru</p>
                            <p class="text-[10px] font-bold opacity-60">{{ callLogs.length }} log</p>
                        </div>

                        <div v-if="callLogs.length" class="grid gap-2 md:grid-cols-2 xl:grid-cols-3">
                            <div v-for="log in callLogs" :key="log.id"
                                :class="['flex items-center gap-3 rounded-lg px-3 py-2 ring-1', getLogClass(log.status)]">
                                <span :class="['h-2.5 w-2.5 shrink-0 rounded-full', getLogDotClass(log.status)]"></span>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-black">{{ logTitle(log) }}</p>
                                    <p class="truncate text-[11px] font-semibold opacity-70">{{ logSubtitle(log) }}</p>
                                </div>
                                <span class="shrink-0 font-mono text-[11px] font-black opacity-70">{{ formatLogTime(log.time) }}</span>
                            </div>
                        </div>

                        <div v-else class="rounded-lg bg-white/60 px-3 py-2 text-sm font-semibold opacity-75 ring-1 ring-black/5 dark:bg-black/20 dark:ring-white/10">
                            Belum ada log panggilan. Alert akan muncul di sini saat aktif.
                        </div>
                    </div>
                </div>

                <button @click="cancelAll"
                    class="flex min-h-[104px] items-center justify-center gap-2 rounded-lg bg-slate-950 px-6 py-4 text-sm font-black text-white shadow-lg shadow-slate-950/15 transition hover:bg-slate-800 active:scale-[0.99] dark:bg-white dark:text-slate-950 dark:hover:bg-slate-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M15 9l-6 6M9 9l6 6" />
                    </svg>
                    Reset
                </button>
            </section>

            <section class="mb-5 grid grid-cols-2 gap-3 lg:grid-cols-4">
                <article v-for="stat in statCards" :key="stat.key"
                    :class="['rounded-lg border bg-white p-4 shadow-sm transition dark:bg-white/[0.06]', stat.borderClass]">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-xs font-black uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400">{{ stat.label }}</p>
                            <p :class="['mt-2 text-4xl font-black leading-none tabular-nums', stat.textClass]">{{ stat.value }}</p>
                        </div>
                        <span :class="['flex h-10 w-10 shrink-0 items-center justify-center rounded-lg', stat.iconClass]">
                            <svg v-if="stat.key === 'infus'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
                            </svg>
                            <svg v-else-if="stat.key === 'perawat'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                            </svg>
                            <svg v-else-if="stat.key === 'emergency'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                                <path d="M12 9v4M12 17h.01" />
                            </svg>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M15 9l-6 6M9 9l6 6" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-4 h-1.5 overflow-hidden rounded bg-slate-100 dark:bg-white/10">
                        <div :class="['h-full rounded', stat.barClass]" :style="{ width: stat.width }"></div>
                    </div>
                </article>
            </section>

            <section>
                <div class="mb-3 flex flex-wrap items-end justify-between gap-2">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-slate-500 dark:text-slate-400">Monitor Ruangan</p>
                        <h2 class="text-lg font-black text-slate-950 dark:text-white">{{ rooms.length }} Ruang KRIS</h2>
                    </div>
                    <div class="flex flex-wrap gap-2 text-xs font-bold">
                        <span class="rounded-lg bg-emerald-100 px-2.5 py-1 text-emerald-800 dark:bg-emerald-400/15 dark:text-emerald-200">Infus</span>
                        <span class="rounded-lg bg-amber-100 px-2.5 py-1 text-amber-800 dark:bg-amber-400/15 dark:text-amber-200">Perawat</span>
                        <span class="rounded-lg bg-rose-100 px-2.5 py-1 text-rose-800 dark:bg-rose-400/15 dark:text-rose-200">Emergency</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5">
                    <article v-for="(room, roomIndex) in rooms" :key="roomIndex"
                        :class="['overflow-hidden rounded-lg border bg-white shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-md dark:bg-[#10182b]', getRoomCardClass(room)]">
                        <div :class="['flex items-center justify-between px-4 py-3', getRoomHeaderClass(room)]">
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-70">Ruang KRIS</p>
                                <p class="text-3xl font-black leading-none tabular-nums">{{ roomIndex + 1 }}</p>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                <span :class="['rounded-lg px-2.5 py-1 text-[10px] font-black uppercase tracking-wide', getRoomStatusChipClass(room)]">
                                    {{ roomStatusLabel(room) }}
                                </span>
                                <span class="relative flex h-3 w-3">
                                    <span v-if="roomHasActive(room)"
                                        :class="['absolute inline-flex h-full w-full animate-ping rounded-full opacity-70', getRoomPingColor(room)]"></span>
                                    <span :class="['relative inline-flex h-3 w-3 rounded-full', getRoomDotColor(room)]"></span>
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2 p-3">
                            <button v-for="(bed, bedIndex) in room.beds" :key="bedIndex" @click="openModal(roomIndex, bedIndex)"
                                :class="['group min-h-[116px] rounded-lg border p-3 text-left transition active:scale-[0.98]', getBedButtonClass(bed)]">
                                <div class="flex items-center justify-between gap-2">
                                    <span :class="['flex h-9 w-9 items-center justify-center rounded-lg', getBedIconClass(bed.status)]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M4 11h16v8H4z" />
                                            <path d="M4 11V8a3 3 0 0 1 3-3h5a3 3 0 0 1 3 3v3" />
                                            <path d="M20 11v8M4 19v2M20 19v2" />
                                        </svg>
                                    </span>
                                    <span class="relative flex h-2.5 w-2.5 shrink-0">
                                        <span v-if="bed.isBlinking"
                                            :class="['absolute inline-flex h-full w-full animate-ping rounded-full opacity-75', getBedPingColor(bed.status)]"></span>
                                        <span :class="['relative inline-flex h-2.5 w-2.5 rounded-full', getBedDotColor(bed.status)]"></span>
                                    </span>
                                </div>
                                <p class="mt-4 text-lg font-black leading-none">Bed {{ bedIndex === 0 ? 'A' : 'B' }}</p>
                                <p :class="['mt-2 text-xs font-black uppercase tracking-wide', getBedLabelClass(bed.status)]">
                                    {{ statusLabelLong(bed.status) }}
                                </p>
                            </button>
                        </div>
                    </article>
                </div>
            </section>
        </main>

        <Teleport to="body">
            <Transition name="modal">
                <div v-if="modal.show" class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <button class="absolute inset-0 cursor-default bg-slate-950/70 backdrop-blur-sm" @click="closeModal" aria-label="Tutup modal"></button>

                    <section class="relative w-full max-w-sm rounded-lg bg-white p-5 shadow-2xl ring-1 ring-slate-200 dark:bg-[#10182b] dark:ring-white/10">
                        <div class="mb-5 flex items-start justify-between gap-3">
                            <div>
                                <p class="text-xs font-black uppercase tracking-[0.18em] text-teal-700 dark:text-teal-300">
                                    Ruang {{ modal.roomIndex + 1 }}
                                </p>
                                <h3 class="mt-1 text-2xl font-black text-slate-950 dark:text-white">
                                    Bed {{ modal.bedIndex === 0 ? 'A' : 'B' }}
                                </h3>
                            </div>
                            <button @click="closeModal"
                                class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 text-slate-500 transition hover:bg-slate-200 hover:text-slate-800 dark:bg-white/10 dark:text-slate-300 dark:hover:bg-white/15">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M18 6 6 18M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <button @click="triggerAction('infus')" :disabled="isLoading"
                                class="rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-left text-emerald-800 transition hover:bg-emerald-100 disabled:opacity-60 dark:border-emerald-400/20 dark:bg-emerald-400/10 dark:text-emerald-100">
                                <ActionIcon type="infus" />
                                <span class="mt-3 block text-sm font-black">Infus</span>
                            </button>
                            <button @click="triggerAction('perawat')" :disabled="isLoading"
                                class="rounded-lg border border-amber-200 bg-amber-50 p-4 text-left text-amber-800 transition hover:bg-amber-100 disabled:opacity-60 dark:border-amber-400/20 dark:bg-amber-400/10 dark:text-amber-100">
                                <ActionIcon type="perawat" />
                                <span class="mt-3 block text-sm font-black">Perawat</span>
                            </button>
                            <button @click="triggerAction('emergency')" :disabled="isLoading"
                                class="rounded-lg border border-rose-200 bg-rose-50 p-4 text-left text-rose-800 transition hover:bg-rose-100 disabled:opacity-60 dark:border-rose-400/20 dark:bg-rose-400/10 dark:text-rose-100">
                                <ActionIcon type="emergency" />
                                <span class="mt-3 block text-sm font-black">Emergency</span>
                            </button>
                            <button @click="triggerAction('cancel')" :disabled="isLoading"
                                class="rounded-lg border border-slate-200 bg-slate-50 p-4 text-left text-slate-700 transition hover:bg-slate-100 disabled:opacity-60 dark:border-white/10 dark:bg-white/5 dark:text-slate-200">
                                <ActionIcon type="cancel" />
                                <span class="mt-3 block text-sm font-black">Cancel</span>
                            </button>
                        </div>

                        <div v-if="isLoading" class="mt-4 flex items-center justify-center gap-2 text-sm font-bold text-slate-500 dark:text-slate-300">
                            <svg class="h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
                            </svg>
                            Mengirim...
                        </div>
                    </section>
                </div>
            </Transition>
        </Teleport>
    </div>
</template>

<script setup>
import { computed, h, onMounted, onUnmounted, ref, watch } from 'vue';
import axios from 'axios';

const ActionIcon = (props) => {
    const paths = {
        infus: [
            h('path', { d: 'M22 12h-4l-3 9L9 3l-3 9H2' }),
        ],
        perawat: [
            h('path', { d: 'M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2' }),
            h('circle', { cx: '9', cy: '7', r: '4' }),
            h('path', { d: 'M22 21v-2a4 4 0 0 0-3-3.87' }),
        ],
        emergency: [
            h('path', { d: 'M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z' }),
            h('path', { d: 'M12 9v4M12 17h.01' }),
        ],
        cancel: [
            h('circle', { cx: '12', cy: '12', r: '10' }),
            h('path', { d: 'M15 9l-6 6M9 9l6 6' }),
        ],
    };

    return h('svg', {
        xmlns: 'http://www.w3.org/2000/svg',
        class: 'h-6 w-6',
        viewBox: '0 0 24 24',
        fill: 'none',
        stroke: 'currentColor',
        'stroke-width': '2.2',
        'stroke-linecap': 'round',
        'stroke-linejoin': 'round',
    }, paths[props.type] || paths.cancel);
};

const modal = ref({ show: false, roomIndex: null, bedIndex: null });
const isLoading = ref(false);

function openModal(roomIndex, bedIndex) {
    unlockAudio();
    modal.value = { show: true, roomIndex, bedIndex };
}

function closeModal() {
    if (isLoading.value) return;
    modal.value.show = false;
}

async function triggerAction(type) {
    const { roomIndex, bedIndex } = modal.value;
    const ruang = roomIndex + 1;
    const bed = bedIndex + 1;

    isLoading.value = true;
    try {
        if (type === 'infus') await axios.get(`/infus/${ruang}/${bed}`);
        else if (type === 'perawat') await axios.get(`/perawat/${ruang}/${bed}`);
        else if (type === 'emergency') await axios.get(`/emergency/${ruang}/0`);
        else if (type === 'cancel') await axios.get(`/cancel/${ruang}/0`);
    } catch (e) {
        console.error('Trigger failed:', e);
    } finally {
        isLoading.value = false;
        modal.value.show = false;
    }
}

const isDark = ref(localStorage.getItem('nurseDarkMode') === 'true');

function applyDark(val) {
    document.documentElement.classList.toggle('dark', val);
}

function toggleDark() {
    isDark.value = !isDark.value;
    localStorage.setItem('nurseDarkMode', isDark.value);
    applyDark(isDark.value);
}

const currentTime = ref('--:--:--');
const currentDate = ref('');
let clockTimer = null;

function updateClock() {
    const now = new Date();
    currentTime.value = now.toLocaleTimeString('id-ID');
    currentDate.value = now.toLocaleDateString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
}

const peringatan = ref({});
const datas = ref({ infusD: 0, perawatD: 0, emergencyD: 0, cancel: 0 });
const callLogs = ref([]);

watch(peringatan, (p) => {
    if (p.status === 'infus') handleAction('infus', p.ruang - 1, p.bed - 1);
    else if (p.status === 'perawat') handleAction('perawat', p.ruang - 1, p.bed - 1);
    else if (p.status === 'cancel') handleCancel(p.ruang - 1);
    else if (p.status === 'emergency') handleEmergency(p.ruang - 1);
});

const rooms = ref(
    Array.from({ length: 14 }, () => ({
        beds: [
            { status: '', isBlinking: false },
            { status: '', isBlinking: false },
        ],
    }))
);

const activeCalls = computed(() => rooms.value.flatMap((room, roomIndex) => (
    room.beds
        .map((bed, bedIndex) => ({ ...bed, roomIndex, bedIndex }))
        .filter((bed) => bed.status)
)));

const activeBedsCount = computed(() => activeCalls.value.length);
const activeRoomsCount = computed(() => rooms.value.filter(roomHasActive).length);
const activeInfusCount = computed(() => activeCalls.value.filter((bed) => bed.status === 'infus').length);
const emergencyRoomsCount = computed(() => rooms.value.filter((room) => room.beds.some((b) => b.status === 'emergency')).length);

const highestSeverity = computed(() => {
    if (activeCalls.value.some((bed) => bed.status === 'emergency')) return 'emergency';
    if (activeCalls.value.some((bed) => bed.status === 'perawat')) return 'perawat';
    if (activeCalls.value.some((bed) => bed.status === 'infus')) return 'infus';
    return 'normal';
});

const priorityLabel = computed(() => ({
    emergency: 'Emergency Aktif',
    perawat: 'Panggilan Perawat',
    infus: 'Panggilan Infus',
    normal: 'Semua Normal',
}[highestSeverity.value]));

const priorityHeadline = computed(() => {
    if (highestSeverity.value === 'emergency') return 'Tangani emergency lebih dulu';
    if (highestSeverity.value === 'perawat') return 'Panggilan perawat sedang aktif';
    if (highestSeverity.value === 'infus') return 'Panggilan infus sedang aktif';
    return 'Seluruh ruangan dalam kondisi tenang';
});

const priorityBadgeClass = computed(() => ({
    emergency: 'bg-rose-100 text-rose-800 ring-rose-200 dark:bg-rose-400/15 dark:text-rose-100 dark:ring-rose-400/20',
    perawat: 'bg-amber-100 text-amber-800 ring-amber-200 dark:bg-amber-400/15 dark:text-amber-100 dark:ring-amber-400/20',
    infus: 'bg-emerald-100 text-emerald-800 ring-emerald-200 dark:bg-emerald-400/15 dark:text-emerald-100 dark:ring-emerald-400/20',
    normal: 'bg-teal-100 text-teal-800 ring-teal-200 dark:bg-teal-400/15 dark:text-teal-100 dark:ring-teal-400/20',
}[highestSeverity.value]));

const priorityDotClass = computed(() => ({
    emergency: 'bg-rose-500 animate-pulse',
    perawat: 'bg-amber-500 animate-pulse',
    infus: 'bg-emerald-500 animate-pulse',
    normal: 'bg-teal-500',
}[highestSeverity.value]));

const priorityPanelClass = computed(() => ({
    emergency: 'border-rose-200 bg-rose-50 text-rose-950 dark:border-rose-400/20 dark:bg-rose-400/10 dark:text-rose-50',
    perawat: 'border-amber-200 bg-amber-50 text-amber-950 dark:border-amber-400/20 dark:bg-amber-400/10 dark:text-amber-50',
    infus: 'border-emerald-200 bg-emerald-50 text-emerald-950 dark:border-emerald-400/20 dark:bg-emerald-400/10 dark:text-emerald-50',
    normal: 'border-teal-200 bg-teal-50 text-teal-950 dark:border-teal-400/20 dark:bg-teal-400/10 dark:text-teal-50',
}[highestSeverity.value]));

const maxStatValue = computed(() => Math.max(1, datas.value.infusD, datas.value.perawatD, datas.value.emergencyD, datas.value.cancel));

const statCards = computed(() => [
    {
        key: 'infus',
        label: 'Infus',
        value: datas.value.infusD,
        textClass: 'text-emerald-600 dark:text-emerald-300',
        iconClass: 'bg-emerald-100 text-emerald-700 dark:bg-emerald-400/15 dark:text-emerald-200',
        borderClass: 'border-emerald-100 dark:border-emerald-400/20',
        barClass: 'bg-emerald-500',
    },
    {
        key: 'perawat',
        label: 'Perawat',
        value: datas.value.perawatD,
        textClass: 'text-amber-600 dark:text-amber-300',
        iconClass: 'bg-amber-100 text-amber-700 dark:bg-amber-400/15 dark:text-amber-200',
        borderClass: 'border-amber-100 dark:border-amber-400/20',
        barClass: 'bg-amber-500',
    },
    {
        key: 'emergency',
        label: 'Emergency',
        value: datas.value.emergencyD,
        textClass: 'text-rose-600 dark:text-rose-300',
        iconClass: 'bg-rose-100 text-rose-700 dark:bg-rose-400/15 dark:text-rose-200',
        borderClass: 'border-rose-100 dark:border-rose-400/20',
        barClass: 'bg-rose-500',
    },
    {
        key: 'cancel',
        label: 'Cancel',
        value: datas.value.cancel,
        textClass: 'text-indigo-600 dark:text-indigo-300',
        iconClass: 'bg-indigo-100 text-indigo-700 dark:bg-indigo-400/15 dark:text-indigo-200',
        borderClass: 'border-indigo-100 dark:border-indigo-400/20',
        barClass: 'bg-indigo-500',
    },
].map((stat) => ({
    ...stat,
    width: `${Math.max(8, (Number(stat.value) / maxStatValue.value) * 100)}%`,
})));

const emergencySound = ref(null);
const perawatSound = ref(null);
const infusSound = ref(null);
const doorSound = ref(null);

const audioUnlocked = ref(false);
function unlockAudio() {
    if (audioUnlocked.value) return;
    audioUnlocked.value = true;
    const audio = new Audio('/audio/bell.mp3');
    audio.volume = 0;
    audio.play().then(() => audio.pause()).catch(() => {});
}

onMounted(() => {
    applyDark(isDark.value);
    updateClock();
    clockTimer = setInterval(updateClock, 1000);
    document.addEventListener('click', unlockAudio, { once: true });

    window.Echo.channel('delivery').listen('PackageSent', (event) => {
        peringatan.value = event;
    });

    getDatas();
});

onUnmounted(() => {
    if (clockTimer) clearInterval(clockTimer);
    stopAllSounds();
});

function handleAction(action, roomIndex, bedIndex) {
    const bed = rooms.value[roomIndex]?.beds[bedIndex];
    if (!bed) return;

    stopAllSounds();
    bed.status = action;
    startBlinking(roomIndex, bedIndex);
    addCallLog(action, roomIndex, bedIndex);

    if (action === 'infus') playInfus(roomIndex, bedIndex);
    if (action === 'perawat') playPerawat(roomIndex, bedIndex);

    getDatas();
}

function handleEmergency(roomIndex) {
    const room = rooms.value[roomIndex];
    if (!room) return;

    stopAllSounds();
    room.beds.forEach((bed) => {
        bed.status = 'emergency';
    });
    startBlinking(roomIndex, null);
    addCallLog('emergency', roomIndex, null);
    playEmergency();
    getDatas();
}

function handleCancel(roomIndex) {
    if (!rooms.value[roomIndex]) return;
    stopAllSounds();
    stopBlinking(roomIndex);
    clearRoomLogs(roomIndex);
    getDatas();
}

function cancelAll() {
    stopAllSounds();
    rooms.value.forEach((room) => {
        room.beds.forEach((bed) => {
            bed.status = '';
            bed.isBlinking = false;
        });
    });
    callLogs.value = [];
    getDatas();
}

function addCallLog(status, roomIndex, bedIndex) {
    callLogs.value.unshift({
        id: `${Date.now()}-${Math.random().toString(16).slice(2)}`,
        status,
        roomIndex,
        bedIndex,
        time: new Date().toISOString(),
    });

    callLogs.value = callLogs.value.slice(0, 6);
}

function clearRoomLogs(roomIndex) {
    callLogs.value = callLogs.value.filter((log) => log.roomIndex !== roomIndex);
}

function stopBlinking(roomIndex) {
    rooms.value[roomIndex].beds.forEach((bed) => {
        bed.isBlinking = false;
        bed.status = '';
    });
}

function startBlinking(roomIndex, bedIndex = null) {
    if (bedIndex !== null) {
        rooms.value[roomIndex].beds[bedIndex].isBlinking = true;
    } else {
        rooms.value[roomIndex].beds.forEach((bed) => {
            bed.isBlinking = true;
        });
    }
}

let perawatTimer = null;
let infusTimer = null;

function stopAllSounds() {
    clearTimeout(perawatTimer);
    clearTimeout(infusTimer);
    perawatTimer = null;
    infusTimer = null;

    [emergencySound, perawatSound, infusSound, doorSound].forEach((sound) => {
        if (!sound.value) return;
        sound.value.pause();
        sound.value.currentTime = 0;
    });
}

function playEmergency() {
    emergencySound.value = new Audio('/audio/e1.mp3');
    emergencySound.value.loop = true;
    emergencySound.value.play().catch(console.error);
}

function playPerawat(roomIndex, bedIndex) {
    doorSound.value = new Audio('/audio/bell.mp3');
    doorSound.value.play().catch(() => {});
    perawatTimer = setTimeout(() => {
        perawatTimer = null;
        perawatSound.value = new Audio(`/audio/perawat_${roomIndex + 1}_${bedIndex + 1}.mp3`);
        perawatSound.value.loop = true;
        perawatSound.value.play().catch(console.error);
    }, 1000);
}

function playInfus(roomIndex, bedIndex) {
    doorSound.value = new Audio('/audio/bell.mp3');
    doorSound.value.play().catch(() => {});
    infusTimer = setTimeout(() => {
        infusTimer = null;
        infusSound.value = new Audio(`/audio/infus_${roomIndex + 1}_${bedIndex + 1}.mp3`);
        infusSound.value.loop = true;
        infusSound.value.play().catch(console.error);
    }, 1000);
}

async function getDatas() {
    const res = await axios.get('/counting');
    datas.value = res.data;
}

function roomHasActive(room) {
    return room.beds.some((bed) => bed.status !== '');
}

function roomStatus(room) {
    if (room.beds.some((bed) => bed.status === 'emergency')) return 'emergency';
    if (room.beds.some((bed) => bed.status === 'perawat')) return 'perawat';
    if (room.beds.some((bed) => bed.status === 'infus')) return 'infus';
    return 'normal';
}

function roomStatusLabel(room) {
    return {
        emergency: 'Emergency',
        perawat: 'Perawat',
        infus: 'Infus',
        normal: 'Standby',
    }[roomStatus(room)];
}

function getRoomCardClass(room) {
    return {
        emergency: 'border-rose-300 shadow-rose-100 dark:border-rose-400/40 dark:shadow-none',
        perawat: 'border-amber-300 shadow-amber-100 dark:border-amber-400/40 dark:shadow-none',
        infus: 'border-emerald-300 shadow-emerald-100 dark:border-emerald-400/40 dark:shadow-none',
        normal: 'border-white/80 dark:border-white/10',
    }[roomStatus(room)];
}

function getRoomHeaderClass(room) {
    return {
        emergency: 'bg-rose-600 text-white',
        perawat: 'bg-amber-500 text-amber-950',
        infus: 'bg-emerald-600 text-white',
        normal: 'bg-slate-100 text-slate-950 dark:bg-white/10 dark:text-white',
    }[roomStatus(room)];
}

function getRoomStatusChipClass(room) {
    return {
        emergency: 'bg-white text-rose-700',
        perawat: 'bg-white/80 text-amber-800',
        infus: 'bg-white text-emerald-700',
        normal: 'bg-white text-slate-600 dark:bg-white/10 dark:text-slate-200',
    }[roomStatus(room)];
}

function getRoomPingColor(room) {
    return {
        emergency: 'bg-rose-200',
        perawat: 'bg-amber-200',
        infus: 'bg-emerald-200',
        normal: 'bg-teal-200',
    }[roomStatus(room)];
}

function getRoomDotColor(room) {
    return {
        emergency: 'bg-rose-50',
        perawat: 'bg-amber-900',
        infus: 'bg-emerald-50',
        normal: 'bg-teal-500',
    }[roomStatus(room)];
}

function getBedButtonClass(bed) {
    if (bed.status === 'infus') return 'border-emerald-200 bg-emerald-50 text-emerald-950 hover:bg-emerald-100 dark:border-emerald-400/20 dark:bg-emerald-400/10 dark:text-emerald-50';
    if (bed.status === 'perawat') return 'border-amber-200 bg-amber-50 text-amber-950 hover:bg-amber-100 dark:border-amber-400/20 dark:bg-amber-400/10 dark:text-amber-50';
    if (bed.status === 'emergency') return 'border-rose-200 bg-rose-50 text-rose-950 hover:bg-rose-100 dark:border-rose-400/20 dark:bg-rose-400/10 dark:text-rose-50';
    return 'border-slate-100 bg-slate-50 text-slate-800 hover:border-teal-200 hover:bg-white dark:border-white/10 dark:bg-white/5 dark:text-slate-100 dark:hover:bg-white/10';
}

function getBedIconClass(status) {
    if (status === 'infus') return 'bg-emerald-600 text-white';
    if (status === 'perawat') return 'bg-amber-500 text-amber-950';
    if (status === 'emergency') return 'bg-rose-600 text-white';
    return 'bg-white text-slate-500 ring-1 ring-slate-200 dark:bg-white/10 dark:text-slate-300 dark:ring-white/10';
}

function getBedLabelClass(status) {
    if (status === 'infus') return 'text-emerald-700 dark:text-emerald-200';
    if (status === 'perawat') return 'text-amber-700 dark:text-amber-200';
    if (status === 'emergency') return 'text-rose-700 dark:text-rose-200';
    return 'text-slate-400 dark:text-slate-500';
}

function getBedPingColor(status) {
    if (status === 'infus') return 'bg-emerald-400';
    if (status === 'perawat') return 'bg-amber-400';
    if (status === 'emergency') return 'bg-rose-400';
    return 'bg-teal-400';
}

function getBedDotColor(status) {
    if (status === 'infus') return 'bg-emerald-600';
    if (status === 'perawat') return 'bg-amber-500';
    if (status === 'emergency') return 'bg-rose-600';
    return 'bg-slate-300 dark:bg-slate-600';
}

function statusLabelLong(status) {
    if (status === 'infus') return 'Infus aktif';
    if (status === 'perawat') return 'Panggil perawat';
    if (status === 'emergency') return 'Emergency';
    return 'Standby';
}

function logTitle(log) {
    if (log.status === 'infus') return 'Infus';
    if (log.status === 'perawat') return 'Panggil Perawat';
    if (log.status === 'emergency') return 'Emergency';
    if (log.status === 'cancelAll') return 'Reset Monitor';
    return 'Cancel';
}

function logSubtitle(log) {
    if (log.status === 'cancelAll') return 'Semua indikator dimatikan';
    if (log.status === 'emergency' || log.status === 'cancel') return `Ruang KRIS ${log.roomIndex + 1}`;

    const bedName = log.bedIndex === 0 ? 'A' : 'B';
    return `Ruang KRIS ${log.roomIndex + 1} - Bed ${bedName}`;
}

function formatLogTime(time) {
    return new Date(time).toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
    });
}

function getLogClass(status) {
    if (status === 'infus') return 'bg-emerald-50 text-emerald-950 ring-emerald-200 dark:bg-emerald-400/10 dark:text-emerald-50 dark:ring-emerald-400/20';
    if (status === 'perawat') return 'bg-amber-50 text-amber-950 ring-amber-200 dark:bg-amber-400/10 dark:text-amber-50 dark:ring-amber-400/20';
    if (status === 'emergency') return 'bg-rose-50 text-rose-950 ring-rose-200 dark:bg-rose-400/10 dark:text-rose-50 dark:ring-rose-400/20';
    return 'bg-slate-50 text-slate-800 ring-slate-200 dark:bg-white/10 dark:text-slate-100 dark:ring-white/10';
}

function getLogDotClass(status) {
    if (status === 'infus') return 'bg-emerald-500';
    if (status === 'perawat') return 'bg-amber-500';
    if (status === 'emergency') return 'bg-rose-500 animate-pulse';
    return 'bg-slate-400';
}
</script>

<style scoped>
.nurse-console {
    background:
        linear-gradient(180deg, rgba(248, 250, 252, 0.9), rgba(238, 242, 247, 0.86)),
        url('/img/1.jpg') center / cover;
}

:global(.dark) .nurse-console {
    background:
        linear-gradient(180deg, rgba(11, 16, 32, 0.78), rgba(13, 23, 42, 0.84)),
        url('/img/1.jpg') center / cover;
}

.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.16s ease, transform 0.16s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
    transform: scale(0.98);
}

.banner-leave-active {
    transition: opacity 0.24s ease, transform 0.24s ease, max-height 0.24s ease, margin 0.24s ease;
}

.banner-leave-to {
    margin-bottom: 0;
    max-height: 0;
    opacity: 0;
    transform: translateY(-4px);
}
</style>
