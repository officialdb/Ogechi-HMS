<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <p class="hms-pill w-fit">Patients Module</p>
            <h2 class="text-3xl font-semibold tracking-tight text-slate-950">Edit patient record</h2>
            <p class="max-w-3xl text-sm leading-6 text-slate-600">
                Update demographic, contact, or emergency details for {{ $patient->full_name }}.
            </p>
        </div>
    </x-slot>

    <div class="space-y-6 px-4 py-8 sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="rounded-[1.4rem] border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        @can('patients.delete')
            <form id="archive-patient-form" method="POST" action="{{ route('patients.destroy', $patient) }}" class="hidden" onsubmit="return confirm('Archive this patient record?');">
                @csrf
                @method('DELETE')
            </form>
        @endcan

        <div class="hms-panel rounded-[1.75rem] p-6 lg:p-8">
            <div class="mb-6 rounded-[1.4rem] border border-slate-200 bg-slate-50/80 px-5 py-4">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Patient ID</p>
                <p class="mt-2 text-lg font-semibold text-slate-950">{{ $patient->patient_number }}</p>
            </div>

            <form method="POST" action="{{ route('patients.update', $patient) }}" class="space-y-8">
                @csrf
                @method('PATCH')

                @include('patients::patients._form')

                <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-200 pt-6">
                    @can('patients.delete')
                        <button form="archive-patient-form" type="submit" class="rounded-full border border-rose-300 px-5 py-3 text-sm font-semibold uppercase tracking-[0.18em] text-rose-700 transition hover:border-rose-500 hover:text-rose-900">
                            Archive Record
                        </button>
                    @else
                        <span></span>
                    @endcan

                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ route('patients.show', $patient) }}" class="rounded-full border border-slate-300 px-5 py-3 text-sm font-semibold uppercase tracking-[0.18em] text-slate-700 transition hover:border-slate-500 hover:text-slate-900">
                            Back
                        </a>
                        <button type="submit" class="rounded-full bg-teal-700 px-5 py-3 text-sm font-semibold uppercase tracking-[0.18em] text-white shadow-lg shadow-teal-900/20 transition hover:bg-teal-800">
                            Update Patient
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
