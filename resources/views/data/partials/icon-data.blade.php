@php
@endphp
@switch($type)
    @case('INTEGRASI')

		<i class="fas fa-exchange-alt"></i>

        @break
     @case('VISUALISASI')
     <i class="fas fa-chart-area"></i>
        @break
      @case('TABLE')
        <i class="fa fa-table"></i> 
        @break
    @case('INFOGRAFIS')
    	<i class="fas fa-image"></i>
    @break

    @default

@endswitch
