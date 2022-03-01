<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-textfield label="Left column title" :name="fieldName('title_left')" type="text" in-store="value" ></a17-textfield><a17-wysiwyg label="Left column content" :name="fieldName('content_left')" :options='{"modules":{"toolbar":["bold","italic","underline","strike",{"color":[]},{"script":"super"},{"script":"sub"},"link","clean"],"syntax":false}}' :maxlength='1000' in-store="value" ></a17-wysiwyg><a17-textfield label="Middle column title" :name="fieldName('title_center')" type="text" in-store="value" ></a17-textfield><a17-wysiwyg label="Middle column content" :name="fieldName('content_center')" :options='{"modules":{"toolbar":["bold","italic","underline","strike",{"color":[]},{"script":"super"},{"script":"sub"},"link","clean"],"syntax":false}}' :maxlength='1000' in-store="value" ></a17-wysiwyg><a17-textfield label="Right column title" :name="fieldName('title_right')" type="text" in-store="value" ></a17-textfield><a17-wysiwyg label="Right column content" :name="fieldName('content_right')" :options='{"modules":{"toolbar":["bold","italic","underline","strike",{"color":[]},{"script":"super"},{"script":"sub"},"link","clean"],"syntax":false}}' :maxlength='1000' in-store="value" ></a17-wysiwyg>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
