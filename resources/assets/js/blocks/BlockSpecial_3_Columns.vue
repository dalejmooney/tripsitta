<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-textfield label="Small title" :name="fieldName('small_title')" type="text" in-store="value" ></a17-textfield><a17-textfield label="Title" :name="fieldName('title')" type="text" in-store="value" ></a17-textfield><a17-vselect label="Shape of images" :name="fieldName('images_shape')" :options='[{&quot;value&quot;:1,&quot;label&quot;:&quot;Circle&quot;},{&quot;value&quot;:2,&quot;label&quot;:&quot;Square&quot;}]' placeholder="Select image shape" :has-default-store="true" size="large" in-store="inputValue" > </a17-vselect><a17-inputframe label="Image left column" name="medias.left_column_image" > <a17-mediafield :name="fieldName('left_column_image')" crop-context="left_column_image" ></a17-mediafield> </a17-inputframe> <a17-textfield label="Subheading left column" :name="fieldName('left_column_subheading')" type="text" in-store="value" ></a17-textfield><a17-wysiwyg label="Content left column" :name="fieldName('left_column_content')" :options='{"modules":{"toolbar":["bold","italic","underline","strike",{"color":[]},{"script":"super"},{"script":"sub"},"link","clean"],"syntax":false}}' :maxlength='500' in-store="value" ></a17-wysiwyg><a17-inputframe label="Image middle column" name="medias.middle_column_image" > <a17-mediafield :name="fieldName('middle_column_image')" crop-context="middle_column_image" ></a17-mediafield> </a17-inputframe> <a17-textfield label="Subheading middle column" :name="fieldName('middle_column_subheading')" type="text" in-store="value" ></a17-textfield><a17-wysiwyg label="Content middle column" :name="fieldName('middle_column_content')" :options='{"modules":{"toolbar":["bold","italic","underline","strike",{"color":[]},{"script":"super"},{"script":"sub"},"link","clean"],"syntax":false}}' :maxlength='500' in-store="value" ></a17-wysiwyg><a17-inputframe label="Image right column" name="medias.right_column_image" > <a17-mediafield :name="fieldName('right_column_image')" crop-context="right_column_image" ></a17-mediafield> </a17-inputframe> <a17-textfield label="Subheading right column" :name="fieldName('right_column_subheading')" type="text" in-store="value" ></a17-textfield><a17-wysiwyg label="Content right column" :name="fieldName('right_column_content')" :options='{"modules":{"toolbar":["bold","italic","underline","strike",{"color":[]},{"script":"super"},{"script":"sub"},"link","clean"],"syntax":false}}' :maxlength='500' in-store="value" ></a17-wysiwyg>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
