<template>
	<div v-if="featuredPlugin">
		<plugin-grid :columns="4" :plugins="getPluginsByIds(featuredPlugin.plugins)"></plugin-grid>
	</div>
</template>

<script>
    import { mapGetters } from 'vuex'
    import PluginGrid from './components/PluginGrid';

    export default {

        components: {
            PluginGrid,
		},

        computed: {

            ...mapGetters({
                getFeaturedPlugin: 'getFeaturedPlugin',
                getPluginsByIds: 'getPluginsByIds',
            }),

			featuredPlugin() {
                let featuredPlugin = this.getFeaturedPlugin(this.$route.params.id);

                if(featuredPlugin) {
                    this.$root.pageTitle = featuredPlugin.title;
                }

                return featuredPlugin;
			}

        },

        created () {
            this.$root.crumbs = [
                {
                    label: "Plugin Store",
                    path: '/',
                }
            ];
        },

    }
</script>