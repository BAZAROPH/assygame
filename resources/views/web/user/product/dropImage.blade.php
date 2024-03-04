<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/basic.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" type="text/css" />

 <style type="text/css">
	.dropzone {
        border: none;
        background: white;
    }
</style>
<div class="" style="width:100%;">
    <div class="needsclick dropzone" id="document-dropzone">
    </div>
</div>

<script src="{{ asset('js/dropzone.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>

<script>
  var uploadedDocumentMap = {}
  Dropzone.options.documentDropzone = {
    url: '{{ route('product.storeMedia') }}',
    maxFilesize: 10, // MB
    addRemoveLinks: true,
    maxFiles: 8,
    dictDefaultMessage: 'Cliquez ici pour ajouter vos images !!<br> 8 images max',
    dictFallbackMessage: "Votre navigateur ne supporte pas le téléchargement de fichiers drag'n'drop.",
    dictFallbackText: "Veuillez utiliser le formulaire de secours ci-dessous pour télécharger vos fichiers comme auparavant.",
    dictInvalidFileType: "Vous ne pouvez pas télécharger des fichiers de ce type.",
    dictCancelUpload: "Annuler",
    dictCancelUploadConfirmation: "Êtes-vous sûr de vouloir annuler ce téléchargement ?",
    dictRemoveFile: "Supprimer",
    dictRemoveFileConfirmation: null,
    dictMaxFilesExceeded: "Vous ne pouvez pas télécharger d'autres fichiers.",
    acceptedFiles: "image/*",
    paramName: 'file',
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">')
      uploadedDocumentMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedDocumentMap[file.name]
      }
      $('form').find('input[name="document[]"][value="' + name + '"]').remove()
    },
    init: function () {
      @if(isset($project) && $project->document)
        var files =
          {!! json_encode($project->document) !!}
        for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">')
        }
      @endif
    }
  }
</script>
