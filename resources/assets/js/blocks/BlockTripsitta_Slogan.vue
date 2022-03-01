<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-wysiwyg label="Content" :name="fieldName('content')" :options='{"modules":{"toolbar":["bold","italic","underline","strike",{"color":[]},{"script":"super"},{"script":"sub"},"link","clean"],"syntax":false}}' :maxlength='500' in-store="value" ></a17-wysiwyg>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
