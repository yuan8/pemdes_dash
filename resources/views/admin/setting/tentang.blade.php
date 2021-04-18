@extends('vendor.adminlte.admin')
@section('content_header')
<h4>TENTANG KAMI</h4>
@stop


@section('content')

<div class="box box-solid">
	<div class="box-body " style="padding-bottom: 100px;">
		<div class="form-group">
			<div id="vueapp">
			  <quill-editor
			    ref="quillEditor"
			    class="editor"
			    v-model="content"
			    :options="editorOption"
			    @blur="onEditorBlur($event)"
			    @focus="onEditorFocus($event)"
			    @ready="onEditorReady($event)"
			  />
			  <br>
			  <div class="content ql-editor" v-html="content"></div>

			</div>
		</div>
	</div>
	<div class="box-footer" id="content-vue">
		<form action="{{route('admin.set.update',['tahun'=>$GLOBALS['tahun_access']])}}" method="post">
			@csrf
		<textarea v-model="content" name="data[TENTANG]" style="display: none;"></textarea>
		<button type="submit" class="btn btn-primary">SIMPAN</button>
		</form>
	</div>
</div>
@stop

@section('js')

<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script type="text/javascript" src="{{asset('bower_components/vue-quill-editor/dist/vue-quill-editor.js')}}"></script>

<!-- Include stylesheet -->
<link href="https://cdn.quilljs.com/1.3.4/quill.core.css" rel="stylesheet">
<link href="https://cdn.quilljs.com/1.3.4/quill.snow.css" rel="stylesheet">
<link href="https://cdn.quilljs.com/1.3.4/quill.bubble.css" rel="stylesheet">
<!-- Theme included stylesheets -->
{{-- <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet"> --}}
{{-- <link href="//cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet"> --}}

<!-- Core build with no theme, formatting, non-essential modules -->
{{-- <link href="//cdn.quilljs.com/1.3.6/quill.core.css" rel="stylesheet"> --}}
{{-- <script src="//cdn.quilljs.com/1.3.6/quill.core.js"></script> --}}

<style type="text/css">
	.quill-editor,
.content {
  background-color: white;
}

.editor {
  height: 500px;
}
.cke_inner{
	display: none;
}
</style>


<script type="text/javascript">
	var content=new Vue({
		el:'#content-vue',
		data:{
			content:'{!!$data['value']!!}'
		}
	})
	 Vue.use(window.VueQuillEditor);
		var editor=new Vue({
		 el: '#vueapp',
		 data: {
	     message: 'Hi from Vue.',
	     content: '{!!$data['value']!!}',
	     editorOption: {
	        theme: 'snow'
	      }
		 	},
	    methods: {
	      onEditorBlur(quill) {
	        console.log('editor blur!', quill)
	      },
	      onEditorFocus(quill) {
	        console.log('editor focus!', quill)
	      },
	      onEditorReady(quill) {
	        console.log('editor ready!', quill)
	      }
	    },
	    watch:{
	    	content:function(val){
	    		window.content.content=val;
	    	}
	    },
	    computed: {
	      editor() {
	        return this.$refs.quillEditor.quill
	      }
	    },
	    mounted() {
	      console.log('this is quill instance object', this.editor)
	    }
	})
</script>

@stop