# Rebuild Decisions

## Platform

- WordPress
- Lightweight custom block theme
- Gutenberg for content editing
- No Elementor or Divi dependency
- The primary header dropdown navigation uses Max Mega Menu on a registered theme location so the main menu remains manageable and clickable in WordPress without a custom JS dropdown layer

## Content Model

- Standard pages for core services
- FAQ als Standardseite mit stabilen Deep Links und einem zentralen Inhaltsblock
- Event content only if workshops and seminars are actually maintained
- No services CPT at launch unless repeated structured content becomes necessary

## Operational Rules

- Store business facts separately from theme code
- Keep contact data, prices, hours and credentials in source-of-truth docs
- Use one form system with SMTP delivery
- Use `Forminator` for the first contact form and route local mail through `Mailpit`
- Add structured data for LocalBusiness, Service, FAQ, Event and ContactPage where relevant

## Launch Requirements

- Finalize opening hours
- Finalize pricing for all public pages
- Add Impressum and Datenschutz
- Add redirects for all legacy URLs
- Verify forms, mobile layout, titles, descriptions and schema before launch
