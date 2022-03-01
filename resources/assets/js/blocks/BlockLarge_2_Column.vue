<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-vselect label="Column setup" :name="fieldName('column_setup')" :options='[{&quot;value&quot;:1,&quot;label&quot;:&quot;Left text, right image&quot;},{&quot;value&quot;:2,&quot;label&quot;:&quot;Left image, right text&quot;}]' placeholder="Select column setup" :has-default-store="true" size="large" in-store="inputValue" > </a17-vselect><a17-textfield label="Title" :name="fieldName('title')" type="text" in-store="value" ></a17-textfield><a17-vselect label="Title font size" :name="fieldName('title_font_size')" :options='[{&quot;value&quot;:1,&quot;label&quot;:&quot;Large&quot;},{&quot;value&quot;:2,&quot;label&quot;:&quot;Medium&quot;},{&quot;value&quot;:3,&quot;label&quot;:&quot;Small&quot;}]' :has-default-store="true" size="large" in-store="inputValue" > </a17-vselect><a17-colorfield label="Title font colour" :name="fieldName('title_font_colour')" in-store="value"
></a17-colorfield><a17-colorfield label="Title line colour" :name="fieldName('title_line_colour')" in-store="value"
></a17-colorfield><a17-wysiwyg label="Content" :name="fieldName('content')" :options='{"modules":{"toolbar":["bold","italic","underline","strike",{"color":[]},{"script":"super"},{"script":"sub"},"link","clean"],"syntax":false}}' :maxlength='500' in-store="value" ></a17-wysiwyg><a17-inputframe label="Image" name="medias.cover" > <a17-mediafield :name="fieldName('cover')" crop-context="cover" ></a17-mediafield> </a17-inputframe> <a17-textfield label="Button text" :name="fieldName('button_text')" type="text" in-store="value" ></a17-textfield><a17-vselect label="Button style" :name="fieldName('button_style')" :options='[{&quot;value&quot;:&quot;primary&quot;,&quot;label&quot;:&quot;Primary&quot;},{&quot;value&quot;:&quot;secondary&quot;,&quot;label&quot;:&quot;Secondary&quot;},{&quot;value&quot;:&quot;dark&quot;,&quot;label&quot;:&quot;Dark&quot;},{&quot;value&quot;:&quot;primary_outlined&quot;,&quot;label&quot;:&quot;Primary outlined&quot;},{&quot;value&quot;:&quot;secondary_outlined&quot;,&quot;label&quot;:&quot;Secondary outlined&quot;},{&quot;value&quot;:&quot;dark_outlined&quot;,&quot;label&quot;:&quot;Dark outlined&quot;}]' :has-default-store="true" size="large" in-store="inputValue" > </a17-vselect><a17-inputframe label="Button page url" name="browsers.pages"> <a17-browserfield :name="fieldName('pages')" item-label="button page url" :max="1" :wide="false" endpoint="/admin/cms/pages/browser" :endpoints="[]" modal-title="Attach button page url" :draggable="true" >Add one button page url</a17-browserfield></a17-inputframe>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
