---
id: home
blueprint: page
title: Home
template: home
sections:
  -
    id: IC1j3ER7
    type: hero
    headline: 'Welcome to your brand new Statamic site'
    subheadline: 'Flat-file CMS with a flexible page builder'
    text: 'Add, reorder, and edit page sections from the Control Panel — no code required.'
    alignment: center
    background: muted
    buttons:
      -
        id: 2okUSznZ
        label: 'View the blog'
        link: /blog
        style: primary
      -
        id: Hjhp0tXV
        label: 'Browse products'
        link: /products
        style: outline
    enabled: true
  -
    id: GU05YyZw
    type: feature_grid
    heading: 'Explore the site'
    subheading: 'Sample collections and taxonomies are ready to customize.'
    columns: '3'
    background: default
    features:
      -
        id: emieJjtg
        title: Blog
        text: 'WordPress-style posts with categories.'
        link: /blog
      -
        id: A4y4ZJPi
        title: Products
        text: 'Catalog with product categories and industries.'
        link: /products
      -
        id: 9FAxJoc1
        title: Dealers
        text: 'Dealer locator with contact details.'
        link: /dealers
    enabled: true
  -
    id: Fu36Plzd
    type: rich_text
    width: narrow
    background: default
    content:
      -
        type: paragraph
        attrs:
          textAlign: left
        content:
          -
            type: text
            text: 'Edit this page in the '
          -
            type: text
            text: 'Control Panel'
            marks:
              -
                type: link
                attrs:
                  href: /cp
          -
            type: text
            text: ' under '
          -
            type: text
            text: 'Pages → Home → Page builder'
            marks:
              -
                type: bold
          -
            type: text
            text: '. Add blocks like hero, feature grid, FAQ, gallery, and more.'
    enabled: true
  -
    id: BU2AvXBT
    type: cta
    heading: 'Ready to build your pages?'
    text: 'Open the page builder and stack sections to match your design.'
    style: banner
    background: default
    buttons:
      -
        id: hMzSl7dD
        label: 'Open Control Panel'
        link: /cp
        style: secondary
    enabled: true
updated_by: 28d34247-1c17-42bf-8548-5b36f18adcbd
updated_at: 1780129244
---
