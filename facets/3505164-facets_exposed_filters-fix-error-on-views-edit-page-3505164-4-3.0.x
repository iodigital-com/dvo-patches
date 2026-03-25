diff --git a/modules/facets_exposed_filters/facets_exposed_filters.module b/modules/facets_exposed_filters/facets_exposed_filters.module
index 2012b8cdd349b7f0eaeb55ed5f8305283a438602..1f9e864c837e02802f558a5f20f0208bc30bce96 100644
--- a/modules/facets_exposed_filters/facets_exposed_filters.module
+++ b/modules/facets_exposed_filters/facets_exposed_filters.module
@@ -46,7 +46,7 @@ function facets_exposed_filters_search_api_query_alter(QueryInterface $query) {
 
   $query_search_api_facets_options = [];
   // Add all facets_filter filters to the search api query as facet.
-  foreach ($view->filter as $filter) {
+  foreach ($view->filter ?? [] as $filter) {
     if ($filter->getPluginId() == "facets_filter") {
       $configuration = $filter->getConfiguration();
       $field_identifier = $configuration["search_api_field_identifier"];
