<a href="{{HP::data_link($d)}}">
	<div class="info-box btn-ov hover-scale hh" style="overflow: hidden;">
  <span class="info-box-icon background-danger-y text-white hover-point">
    @include('data.partials.icon-data',['type'=>$d->type])
  </span>
  <div class="info-box-content">
    <span class="info-box-text">
     <b>{{$d->title}}</b>
    </span>

    <span class="progress-description text-muted one-line">
      {{$d->deskripsi}}
    </span>
    @if(strlen($d->deskripsi)>120)
      <button class="btn btn-xs btn-info" style="font-size:8px;" onclick="showForm('{{route('api.data.desc',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id])}}')">Deskripsi Lengkap</button>
      @endif
      <div class="progress">
        <div class="progress"></div>
      </div>
      @if($d->type=='AUTOMATION')

        @elseif($d->type=='FILE' and $d->type!='CONTROLLER')
          <div class="btn-group">
            <a href="{{url($d->document_path)}}" download="" class="btn btn-success btn-xs">Download</a>
          </div>


          @endif
          -{{-- <span class="badge bg-yellow"><b><a class="text-white" href="{{route('query.data.categorycal',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->organization_id,HPV::slugify($d->oranization_name)])}}">{{'@'.$d->oranization_name}}</a></b></span> --}}

  </div>

  <!-- /.info-box-content -->
</div>
</a>