@props(['name', 'class' => 'w-5 h-5'])

@switch($name)
  @case('dashboard')
    <svg viewBox="0 0 24 24" class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10.5 12 3l9 7.5M5 9.5V20a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1V9.5"/></svg>
    @break

  @case('wallet')
    <svg viewBox="0 0 24 24" class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7a2 2 0 012-2h13a1 1 0 011 1v3M3 7v10a2 2 0 002 2h14a1 1 0 001-1v-6a1 1 0 00-1-1h-4a2 2 0 100 4h4"/></svg>
    @break

  @case('tunai')
    <svg viewBox="0 0 24 24" class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 8.25v10.5a1.5 1.5 0 001.5 1.5h16.5a1.5 1.5 0 001.5-1.5V8.25M2.25 8.25l1.72-3.44a1.5 1.5 0 011.34-.81h13.38a1.5 1.5 0 011.34.81l1.72 3.44M8.25 13.5h1.5"/></svg>
    @break

  @case('bank')
    <svg viewBox="0 0 24 24" class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M4 21V10.5M20 21V10.5M2.5 10.5l9-6 9 6M6 14v3.5M10 14v3.5M14 14v3.5M18 14v3.5"/></svg>
    @break

  @case('e-wallet')
    <svg viewBox="0 0 24 24" class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3M9 18h6"/></svg>
    @break

  @case('category')
    <svg viewBox="0 0 24 24" class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-1.354.111-2.72.167-4.096.167A38 38 0 018.5 17V19a1 1 0 01-1.707.707L4.5 17.414a3 3 0 01-.878-2.121V8.511m16.628 0A48 48 0 0012 8c-2.647 0-5.257.19-7.822.511m16.45 0a3 3 0 00-2.928-2.489C16.19 5.83 14.106 5.7 12 5.7s-4.19.13-5.7.322A3 3 0 003.372 8.51"/></svg>
    @break

  @case('users')
    <svg viewBox="0 0 24 24" class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.4 9.4 0 002.625.372 9.3 9.3 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.3 12.3 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0112.74 0zM8.624 9.75a3.375 3.375 0 100-6.75 3.375 3.375 0 000 6.75zm6.75-2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
    @break

  @case('plus')
    <svg viewBox="0 0 24 24" class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
    @break

  @case('chevron-left')
    <svg viewBox="0 0 24 24" class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    @break

  @case('chevron-right')
    <svg viewBox="0 0 24 24" class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
    @break

  @case('pencil')
    <svg viewBox="0 0 24 24" class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
    @break

  @case('trash')
    <svg viewBox="0 0 24 24" class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9M19.5 5.5A48 48 0 0016 5.313V4.5a2.25 2.25 0 00-2.25-2.25h-3.5A2.25 2.25 0 008 4.5v.813A48 48 0 004.5 5.5m15 0l-.833 14.15A2.25 2.25 0 0116.42 21.75H7.58a2.25 2.25 0 01-2.247-2.1L4.5 5.5m15 0h-15"/></svg>
    @break

  @case('close')
    <svg viewBox="0 0 24 24" class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
    @break

  @case('arrow-in')
    <svg viewBox="0 0 24 24" class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19V5m0 14l-5-5m5 5l5-5"/></svg>
    @break

  @case('arrow-out')
    <svg viewBox="0 0 24 24" class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m0 0l-5-5m5 5l5-5"/></svg>
    @break

  @case('warning')
    <svg viewBox="0 0 24 24" class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12v-.008zM21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    @break

  @case('chart')
    <svg viewBox="0 0 24 24" class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.5l4.5-4.5 4 4L21 4.5M21 4.5H15M21 4.5v6M3 19.5h18"/></svg>
    @break

  @case('logo')
    <svg viewBox="0 0 24 24" class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7a2 2 0 012-2h13a1 1 0 011 1v3M3 7v10a2 2 0 002 2h14a1 1 0 001-1v-6a1 1 0 00-1-1h-4a2 2 0 100 4h4"/></svg>
    @break

  @case('logout')
    <svg viewBox="0 0 24 24" class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0110.5 3h6a2.25 2.25 0 012.25 2.25v13.5A2.25 2.25 0 0116.5 21h-6a2.25 2.25 0 01-2.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/></svg>
    @break

  @case('pay')
    <svg viewBox="0 0 24 24" class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0-.621.504-1.125 1.125-1.125h17.25c.621 0 1.125.504 1.125 1.125v10.5c0 .621-.504 1.125-1.125 1.125H3.375A1.125 1.125 0 012.25 17.25V6.75zM2.25 9.75h19.5M6 15h.008v.008H6V15zm3 0h3.75v.008H9V15z"/></svg>
    @break

  @default
    <svg viewBox="0 0 24 24" class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/></svg>
@endswitch
