# PB-002 Visual Testing Checklist

## Prerequisites

✅ Plugin registered in `AdminPanelProvider.php`
✅ Migrations run (`templates`, `template_sections`, `template_components` tables exist)
✅ Dev server running (`composer run dev`)

## Testing Checklist

### 1. Navigation & Resource Access

**What to Test:**
- [ ] Navigate to `/admin` and login
- [ ] Look for "Page Builder" navigation group in the sidebar
- [ ] Click on "Templates" menu item

**Expected Results:**
- ✅ "Page Builder" group appears in navigation
- ✅ "Templates" menu item visible with document-duplicate icon
- ✅ List page loads without errors

### 2. Templates List Page

**What to Test:**
- [ ] View empty table state
- [ ] Check table columns: Name, Handle, Status, Sections Count, Pages Using
- [ ] Test search functionality (type in search box)
- [ ] Test status filter dropdown
- [ ] Click "New Template" button

**Expected Results:**
- ✅ Table shows proper columns with sorting
- ✅ Empty state message: "No templates yet"
- ✅ Search box works
- ✅ Status filter shows: Draft, Published, Archived
- ✅ "New Template" button redirects to create page

### 3. Create Template - Basic Info

**What to Test:**
- [ ] Fill in "Name" field (e.g., "Test Project Template")
- [ ] Watch "Handle" auto-generate as you type
- [ ] Manually edit "Handle" to test uniqueness validation
- [ ] Add description (optional)
- [ ] Select "Status" dropdown (Draft, Published, Archived)

**Expected Results:**
- ✅ Handle auto-generates as lowercase-hyphenated slug
- ✅ Handle field accepts manual edits
- ✅ Validation prevents duplicate handles
- ✅ Status defaults to "Draft"

### 4. Template Structure Builder - Sections

**What to Test:**
- [ ] Click "Add item" under "Template Sections"
- [ ] Fill in section fields:
  - Key: "hero"
  - Type: Select "Layout Section" vs "Content Section"
  - Order: Auto-populated
- [ ] Expand "Responsive Settings"
- [ ] Collapse/expand the section item

**Expected Results:**
- ✅ Section form appears with all fields
- ✅ Key field accepts text input
- ✅ Type dropdown shows: "Layout Section" and "Content Section"
- ✅ Responsive Settings section expandable
- ✅ Item can be collapsed/expanded
- ✅ Item label shows section key

### 5. Responsive Settings Builder

**What to Test:**
- [ ] Click on different breakpoint tabs (xs, sm, md, lg, xl)
- [ ] Select "Load Preset" dropdown
- [ ] Choose a preset (e.g., "Container")
- [ ] Watch settings auto-fill
- [ ] Manually change "Width" dropdown
- [ ] Change "Padding" dropdown
- [ ] Enter custom "Max Width"
- [ ] Click "Copy to All" button

**Expected Results:**
- ✅ 5 breakpoint tabs visible with icons
- ✅ Active tab highlighted
- ✅ Preset dropdown shows: Full Width, Container, Sidebar Layout, etc.
- ✅ Selecting preset populates all breakpoint settings
- ✅ Width options: Full, Container, Narrow
- ✅ Padding options: None, Small, Medium, Large, Extra Large
- ✅ Max Width accepts custom values
- ✅ "Copy to All" duplicates current breakpoint to others

### 6. Component Builder

**What to Test:**
- [ ] Inside a section, click "Add item" under "Components"
- [ ] Click "Type" dropdown - see all components grouped by category
- [ ] Select a component (e.g., "Content Components: Project Hero")
- [ ] Watch "Slug" auto-populate
- [ ] Check if "Blueprint Version" field appears (depends on component type)
- [ ] Select a blueprint version if required
- [ ] Expand "Template Keys Mapping"

**Expected Results:**
- ✅ Component form appears
- ✅ Type dropdown shows 9 components in 4 categories:
  - Layout: Container, Grid, Flex
  - Content: Project Hero, Text Block, Image Gallery
  - Media: Video Player, Image
  - Forms: Contact Form
- ✅ Slug auto-generates with timestamp
- ✅ Blueprint Version field conditional on component type
- ✅ Blueprint Version dropdown shows available blueprints
- ✅ Component item label shows type and slug

### 7. Template Keys Mapper

**What to Test:**
- [ ] View template keys schema (if component has keys)
- [ ] See required fields marked with asterisk (*)
- [ ] Enter field mappings (e.g., `title` → `page_title`)
- [ ] Leave required field empty
- [ ] Check validation error display
- [ ] Enter unknown key
- [ ] Remove a mapping with X button

**Expected Results:**
- ✅ Schema shows defined keys with types
- ✅ Required keys marked with red *
- ✅ Each key has input field for mapping
- ✅ Validation errors show for missing required keys
- ✅ Validation errors show for unknown keys
- ✅ Red error box appears with validation messages
- ✅ X button removes mapping

**Example Template Keys for Project Hero:**
```
title* (string) → page_title
subtitle (string) → page_subtitle  
image (media) → hero_image
```

### 8. Nested Sections (Layout Section only)

**What to Test:**
- [ ] Create a "Layout Section" type section
- [ ] Look for "Nested Sections" repeater
- [ ] Add child section inside
- [ ] Verify "Content Section" doesn't show "Nested Sections"
- [ ] Try nesting multiple levels (up to 10)

**Expected Results:**
- ✅ "Nested Sections" appears only for Layout Section type
- ✅ Can add child sections
- ✅ Child sections have same form structure
- ✅ Content Section type has no nested sections option
- ✅ Nesting works up to configured depth (10 levels)

### 9. Ordering & Reordering

**What to Test:**
- [ ] Add multiple sections
- [ ] Look for drag handle icons
- [ ] Drag sections to reorder
- [ ] Add multiple components in a section
- [ ] Reorder components by dragging
- [ ] Check "Order" field updates

**Expected Results:**
- ✅ Drag handles visible on items
- ✅ Can drag to reorder
- ✅ Order field updates automatically
- ✅ Visual feedback during drag
- ✅ Order persists after reordering

### 10. Save & Validation

**What to Test:**
- [ ] Leave required fields empty (Name, Handle)
- [ ] Try to save
- [ ] Check validation error messages
- [ ] Fill all required fields
- [ ] Save template
- [ ] Check success notification

**Expected Results:**
- ✅ Validation prevents save with missing required fields
- ✅ Error messages appear on invalid fields
- ✅ Red error highlighting on invalid inputs
- ✅ Success notification on valid save
- ✅ Redirects to edit page after creation

### 11. Edit Template

**What to Test:**
- [ ] From list page, click edit action on a template
- [ ] Modify basic info
- [ ] Edit existing sections/components
- [ ] Add new sections/components
- [ ] Delete sections/components
- [ ] Preview structure
- [ ] Save changes

**Expected Results:**
- ✅ Edit page loads with existing data
- ✅ All fields populated correctly
- ✅ Nested structure preserved
- ✅ Can modify any field
- ✅ Delete buttons work for items
- ✅ Changes persist on save

### 12. Preview Template

**What to Test:**
- [ ] Click "Preview" action from list or edit page
- [ ] View "Template Info" section
- [ ] Check "Template Structure (Frontend Format)" JSON
- [ ] Verify JSON structure matches frontend interface
- [ ] Check "Raw Template Data" section

**Expected Results:**
- ✅ Preview page loads
- ✅ Template info displays: Name, Handle, Status, Section count
- ✅ Frontend format JSON shows nested structure
- ✅ JSON format matches `CmsPageLayout` interface
- ✅ Raw data shows database representation
- ✅ JSON is properly formatted and readable

**Expected JSON Structure:**
```json
{
  "type": "layout_section",
  "data": {
    "layout_id": 1,
    "layout_key": "test-project-template",
    "layout_settings": {},
    "columns": [
      {
        "id": 1,
        "key": "hero",
        "index": 0,
        "settings": {...},
        "components": [...]
      }
    ]
  }
}
```

### 13. Status Management

**What to Test:**
- [ ] Create template as "Draft"
- [ ] Change status to "Published"
- [ ] Save and verify
- [ ] Change to "Archived"
- [ ] Filter list by status
- [ ] Check badge colors

**Expected Results:**
- ✅ Draft badge: Gray
- ✅ Published badge: Green
- ✅ Archived badge: Red
- ✅ Status filter works correctly
- ✅ Status changes persist

### 14. Delete Template

**What to Test:**
- [ ] From list, click delete action
- [ ] Confirm deletion dialog
- [ ] Cancel deletion
- [ ] Delete a template
- [ ] Check soft delete (template still in DB)
- [ ] Verify removed from list

**Expected Results:**
- ✅ Confirmation dialog appears
- ✅ Cancel preserves template
- ✅ Delete removes from list
- ✅ Soft delete (deleted_at timestamp set)
- ✅ Success notification shown

### 15. Table Features

**What to Test:**
- [ ] Test sorting on columns (Name, Handle, Created At)
- [ ] Copy handle using copy icon
- [ ] Toggle column visibility
- [ ] Test pagination (if > 10 templates)
- [ ] Bulk select templates
- [ ] Bulk delete action

**Expected Results:**
- ✅ Columns sortable (ascending/descending)
- ✅ Copy icon copies handle to clipboard
- ✅ "Copied" toast notification
- ✅ Columns can be hidden/shown
- ✅ Pagination works correctly
- ✅ Bulk actions available

### 16. Component Registry Integration

**What to Test:**
- [ ] Create component with blueprint requirement
- [ ] Verify blueprint dropdown is filtered by type
- [ ] Create layout component (no blueprint)
- [ ] Verify blueprint field hidden
- [ ] Test validation of component types

**Expected Results:**
- ✅ Components requiring blueprints show blueprint field
- ✅ Blueprint dropdown filtered to matching types
- ✅ Layout components don't show blueprint field
- ✅ Invalid component type rejected

### 17. Responsive Design Testing

**What to Test:**
- [ ] Resize browser window
- [ ] Check mobile responsiveness
- [ ] Test tablet view
- [ ] Verify form remains usable at all sizes

**Expected Results:**
- ✅ Layout adapts to smaller screens
- ✅ Forms remain functional on mobile
- ✅ No horizontal scrolling
- ✅ Touch-friendly on tablets

### 18. Error Handling

**What to Test:**
- [ ] Enter invalid JSON in component data
- [ ] Try duplicate handle
- [ ] Enter special characters in fields
- [ ] Test with missing blueprint versions

**Expected Results:**
- ✅ Validation errors displayed clearly
- ✅ Duplicate handle prevented
- ✅ Special characters handled properly
- ✅ Missing blueprints show error

## Known Limitations (Current Phase)

- ⚠️ No visual drag-drop builder (Livewire) - uses Filament repeaters
- ⚠️ No auto-save functionality - manual save required
- ⚠️ Template keys validation happens on preview, not real-time
- ⚠️ No undo/redo functionality
- ⚠️ Component data is raw JSON text field

These are **optional enhancements** and can be added in future iterations.

## Common Issues & Solutions

### Issue: Templates menu not showing
**Solution:** Clear cache: `php artisan filament:clear-cached-components`

### Issue: Form not loading
**Solution:** Check browser console for JS errors, ensure assets published

### Issue: Responsive settings not working
**Solution:** Verify Alpine.js is loaded, check browser console

### Issue: Blueprint dropdown empty
**Solution:** Ensure blueprints exist in database with matching types

### Issue: Template keys not validating
**Solution:** Check component type is configured in `template-components.php`

## Success Criteria

✅ All 18 test sections pass without critical errors
✅ Can create, edit, preview, and delete templates
✅ Sections and components can be added/removed/reordered
✅ Responsive settings work across breakpoints
✅ Template keys validation shows errors
✅ Preview shows correct JSON structure
✅ No console errors in browser

## Next Steps After Testing

Once PB-002 visual testing is complete:
1. Report any bugs or UX issues
2. Suggest UI improvements
3. Move to PB-003: REST API & Integration Layer
4. Test API consumption of templates
