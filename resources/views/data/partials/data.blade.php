	<div class="info-box btn-ov hover-scale hh" style="overflow: hidden;">
  <span class="info-box-icon background-danger-y text-white hover-point">
    @include('data.partials.icon-data',['type'=>$d->type])
  </span>
  <div class="info-box-content">
    <span class="info-box-text">
<a href="{{HP::data_link($d)}}">

     <b>{{$d->title}}  <span style="font-size:10px">{{($d->type!='INTEGRASI')?'Tahun '.$d->tahun:'Tahun '.$GLOBALS['tahun_access']}} {{$d->nama_category}}</span></b>
    </span>
  </a>
    @php
    @endphp

    <span class="progress-description text-muted one-line" >
     <span style="font-size:10px;"><b>{{$d->type!='INTEGRASI'?$d->nama_daerah.' - ':(null!==($d->def_nama_instansi??null)?$d->def_nama_instansi.' - ':'')}}</b></span><span style="font-size:8px;">{{$d->deskripsi}}</span>

    </span>
    @if(strlen($d->deskripsi)>120)

      <button class="btn btn-xs btn-info" style="font-size:8px;" onclick="showForm('{{route('api.data.desc',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id])}}')">Deskripsi Lengkap</button>
      @endif
      <div class="progress">
        <div class="progress"></div>
      </div>

      @if($d->type=='INTEGRASI')

      @else
        @php
          // dd($d);
        @endphp
      {{Carbon\Carbon::parse($d->publish_date)->format('d F Y h:i a')}}
        @php
          
        @endphp

      @endif

     

  </div>

</div>
