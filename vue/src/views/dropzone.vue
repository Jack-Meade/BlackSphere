<template>
  <div class="components-container">
    <aside>
      Use Drag and Drop or file browser to upload your files.
    </aside>
    <div class="editor-container"> <!--https://httpbin.org/post -->
      <dropzone id="myVueDropzone" url="http://localhost:3000/upload/" @dropzone-removedFile="dropzoneR" @dropzone-success="dropzoneS" />
    </div>
  </div>
</template>

<script>
import Dropzone from '@/components/Dropzone'

export default {
  name: 'DropzoneDemo',
  components: { Dropzone },
  methods: {
    dropzoneS(file) {
      console.log(file)
      this.$message({ message: 'Upload Successful', type: 'success' })
    },
    dropzoneR(file) {
      console.log(file)
      this.$message({ message: 'Deleted', type: 'success' })
    }
  }
}
</script>
