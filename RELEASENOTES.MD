# 0.2 - 10/14/18
- Changed SimpleKB_CPT class to SimpleKB.
- Moved add_shortcode from __construct to after shortcode function.
- Moved instantation of SimpleKB later in code.
- Moved flush permalinks into plugin activation.
- Changed with_front value on taxonomy from 'false' to false, thanks cry0bot (reddit).
- Changed slug for taxonomy from subject to kb/subject.
- Refactored skb_query (shortcode function) to skb_get_kbs_shortcode.
- Updated register_activation_hook and register_deactivation_hook to reference $SimpleKB instead of $SimpleKB_CPT.

# 0.1.1 - 10/12/18
- Added these release notes.

# 0.1 - 10/12/18
- Initial Code Release
- Includes a Custom Post Type (skb) and a Custom Taxonomy (skb_subjects).
- Includes a shortcode [simplekb] to display all skb's.
