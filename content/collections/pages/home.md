---
title: Home
id: home
template: home
blueprint: page
sections:
  -
    type: hero
    headline: 'Welcome to your brand new Statamic site'
    subheadline: 'Flat-file CMS with a flexible page builder'
    text: 'Add, reorder, and edit page sections from the Control Panel — no code required.'
    alignment: center
    background: muted
    buttons:
      -
        label: 'View the blog'
        link: /blog
        style: primary
      -
        label: 'Browse products'
        link: /products
        style: outline
  -
    type: feature_grid
    heading: 'Explore the site'
    subheading: 'Sample collections and taxonomies are ready to customize.'
    columns: '3'
    background: default
    features:
      -
        title: Blog
        text: 'WordPress-style posts with categories.'
        link: /blog
      -
        title: Products
        text: 'Catalog with product categories and industries.'
        link: /products
      -
        title: Dealers
        text: 'Dealer locator with contact details.'
        link: /dealers
  -
    type: rich_text
    width: narrow
    background: default
    content: '<p>Edit this page in the <a href="/cp">Control Panel</a> under <strong>Pages → Home → Page builder</strong>. Add blocks like hero, feature grid, FAQ, gallery, and more.</p>'
  -
    type: cta
    heading: 'Ready to build your pages?'
    text: 'Open the page builder and stack sections to match your design.'
    style: banner
    background: default
    buttons:
      -
        label: 'Open Control Panel'
        link: /cp
        style: secondary
---
