# Accelsiors Modern FSE Theme

**Theme Name:** Accelsiors Modern FSE
**Version:** 1.9.0
**Author:** Accelsiors Dev Team (Ioannis Passalidis)
**Description:** Custom FSE theme based on 2026 Rebranding Proposal. Focus on HexaHelix & Speed.

---

## Installation

1.  Download the theme as a `.zip` file.
2.  In your WordPress admin, go to **Appearance > Themes > Add New**.
3.  Click **Upload Theme** and choose the downloaded `.zip` file.
4.  Activate the theme.

---

## Features

This theme includes several custom features to extend the functionality of the block editor.

### 1. Mega Menu

A custom, responsive mega menu has been built to replace the default navigation block.

#### How to Set Up:

1.  **Create Your Menu:** Go to **Appearance > Menus**. Create a new menu or edit an existing one.
2.  **Assign Menu Location:** At the bottom of the menu editor, under "Display location", check the **Primary Menu** box.
3.  **Enable Mega Menu:**
    *   On any top-level menu item you want to turn into a mega menu, click the arrow on the right to open its details.
    *   If you don't see a "CSS Classes" field, go to the "Screen Options" tab at the top right of the page and check the "CSS Classes" box.
    *   In the "CSS Classes" field for the menu item, type `mega-menu`.
    *   The submenu under this item will now behave as a mega menu, with its child items automatically arranged into columns.
4.  **Add Images to Menu Items:**
    *   Go to "Screen Options" and ensure the "Description" box is checked.
    *   Open the details for any menu item (top-level or submenu item).
    *   In the "Description" field, paste the full URL of the image you want to display next to the menu item title. The image will be displayed automatically.

### 2. Contact Page 

The theme includes a dedicated settings page and a block pattern to create a consistent and easy-to-manage contact page.

#### How to Set Up:

1.  **Configure Settings:**
    *   Go to **Settings > Contact Page** in the WordPress admin.
    *   Fill out all the fields: contact details, social media URLs, headquarters address, and the shortcode for your contact form (e.g., from a plugin like Contact Form 7).
2.  **Use the Block Pattern:**
    *   Create a new page or edit your existing contact page.
    *   Click the `+` icon to add a new block and choose "Patterns".
    *   Select the **Accelsiors Custom Blocks** category from the dropdown.
    *   Click on the **Contact Page Layout** pattern to insert it.
    *   The pattern will automatically populate with the information you entered in the settings page.

This approach prevents the "invalid content" errors that can occur with manually edited blocks, as the structure is defined in a controlled PHP file.

### 3. Custom Block Styles

The theme provides several custom styles for core WordPress blocks. You can select them in the block settings sidebar under the "Styles" panel.

*   **Group Block (`core/group`):**
    *   `Hero: Cinematic Split`: For creating a split-layout hero section.
    *   `Hero: Centered Stack`: For a centered hero layout.
    *   `Grid: 3 Cols`: Arranges inner blocks into a 3-column grid.
    *   `Grid: 4 Cols`: Arranges inner blocks into a 4-column grid.
*   **Columns Block (`core/columns`):**
    *   `Vertical Cards (Poster)`
    *   `Horizontal Cards (Landscape)`

---

This guide should help you get the most out of the Accelsiors Modern FSE theme.
