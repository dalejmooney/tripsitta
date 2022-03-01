<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-textfield label="Small title" :name="fieldName('small_title')" type="text" in-store="value" ></a17-textfield><a17-textfield label="Title" :name="fieldName('title')" type="text" in-store="value" ></a17-textfield><a17-textfield label="Bullet 1" :name="fieldName('bullet_1')" type="text" in-store="value" ></a17-textfield><a17-textfield label="Bullet 2" :name="fieldName('bullet_2')" type="text" in-store="value" ></a17-textfield><a17-textfield label="Bullet 3" :name="fieldName('bullet_3')" type="text" in-store="value" ></a17-textfield><a17-textfield label="Bullet 4" :name="fieldName('bullet_4')" type="text" in-store="value" ></a17-textfield><a17-inputframe label="Image" name="medias.cover" > <a17-mediafield :name="fieldName('cover')" crop-context="cover" ></a17-mediafield> </a17-inputframe> <a17-wysiwyg label="Content" :name="fieldName('content')" :options='{"modules":{"toolbar":["bold","italic","underline","strike",{"color":[]},{"script":"super"},{"script":"sub"},"link","clean"],"syntax":false}}' :maxlength='750' in-store="value" ></a17-wysiwyg>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
