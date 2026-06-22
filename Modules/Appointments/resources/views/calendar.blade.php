<x-admin-layout title="Appointments Calendar">
<div class="space-y-6">
    
    {{-- ── HEADER ─────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Appointments Calendar</h1>
            <p class="text-sm text-slate-500 mt-1">Visual overview of hospital schedules</p>
        </div>
        <div class="flex items-center gap-3">
            {{-- View Toggles --}}
            <div class="bg-slate-100 p-1 rounded-xl flex items-center border border-slate-200">
                <a href="{{ route('modules.appointments.index') }}" class="px-3 py-1.5 text-xs font-semibold rounded-lg text-slate-500 hover:text-slate-700 transition-colors">
                    List
                </a>
                <a href="{{ route('modules.appointments.index', ['view' => 'calendar']) }}" class="px-3 py-1.5 text-xs font-bold rounded-lg bg-white text-blue-600 shadow-sm transition-colors">
                    Calendar
                </a>
            </div>

            <a href="{{ route('modules.appointments.create') }}" class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white rounded-xl shadow-md transition-all hover:opacity-90" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Schedule
            </a>
        </div>
    </div>

    {{-- ── CALENDAR ───────────────────────────────────── --}}
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6">
        
        <div class="flex items-center gap-4 mb-4 text-xs font-bold text-slate-600 border-b border-slate-100 pb-4">
            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span> Confirmed</span>
            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Completed</span>
            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> Pending</span>
            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-slate-400"></span> Cancelled</span>
        </div>

        <div id="calendar" style="min-height: 600px;"></div>
    </div>

</div>

{{-- FullCalendar Assets --}}
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var events = @json($allAppointments);

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            timeZone: 'local',
            headerToolbar: {
                left:   'prev,next today',
                center: 'title',
                right:  'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            buttonText: {
                today:    'Today',
                month:    'Month',
                week:     'Week',
                day:      'Day',
                list:     'Agenda'
            },
            events: events,
            eventTimeFormat: {
                hour:     'numeric',
                minute:   '2-digit',
                meridiem: 'short'
            },
            // Navigate to the appointment detail page on click
            eventClick: function(info) {
                info.jsEvent.preventDefault();
                if (info.event.url) {
                    window.location.href = info.event.url;
                }
            },
            eventDidMount: function(info) {
                info.el.style.borderRadius = '6px';
                info.el.style.padding      = '2px 5px';
                info.el.style.border       = 'none';
                info.el.style.fontSize     = '11px';
                info.el.style.fontWeight   = 'bold';
                info.el.style.cursor       = 'pointer';

                var status = info.event.extendedProps.status ?? '';
                var reason = info.event.extendedProps.reason ?? '';
                info.el.title = info.event.title
                    + (status ? '\nStatus: ' + status.charAt(0).toUpperCase() + status.slice(1) : '')
                    + (reason ? '\nReason: ' + reason : '');
            }
        });

        calendar.render();

        // Tailwind-friendly FullCalendar overrides
        const style = document.createElement('style');
        style.innerHTML = `
            .fc-theme-standard td, .fc-theme-standard th { border-color: #f1f5f9; }
            .fc .fc-toolbar-title { font-size: 1.15rem; font-weight: 800; color: #0f172a; }
            .fc .fc-button-primary { background:#fff; color:#475569; border:1px solid #e2e8f0; border-radius:.5rem; font-weight:600; box-shadow:0 1px 2px 0 rgb(0 0 0/.05); text-transform:capitalize; }
            .fc .fc-button-primary:hover { background:#f8fafc; color:#0f172a; border-color:#cbd5e1; }
            .fc .fc-button-primary:disabled { background:#f8fafc; color:#94a3b8; border-color:#f1f5f9; }
            .fc .fc-button-active { background:#eff6ff !important; color:#2563eb !important; border-color:#bfdbfe !important; }
            .fc-col-header-cell-cushion { color:#64748b; font-weight:700; font-size:.75rem; text-transform:uppercase; padding:.5rem !important; }
            .fc-daygrid-day-number { color:#475569; font-weight:600; font-size:.875rem; padding:.5rem !important; }
            .fc-day-today { background:#eff6ff !important; }
            .fc-day-today .fc-daygrid-day-number { color:#2563eb; font-weight:800; }
            .fc-event { cursor:pointer; transition:transform .1s, opacity .1s; }
            .fc-event:hover { opacity:.88; transform:scale(1.02); }
            .fc .fc-timegrid-slot { height:2.5em; }
            .fc-list-event:hover td { background:#f8fafc; }
        `;
        document.head.appendChild(style);
    });
</script>
</x-admin-layout>

