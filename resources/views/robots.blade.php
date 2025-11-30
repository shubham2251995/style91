User-agent: *
Allow: /

# Sitemap
Sitemap: {{ config('app.url') }}/sitemap.xml

# Disallow admin and private areas
Disallow: /admin/
Disallow: /api/
Disallow: /install/
Disallow: /cart/
Disallow: /checkout/
Disallow: /profile/
Disallow: /login/
Disallow: /register/

# Allow product and category pages
Allow: /product/
Allow: /category/
Allow: /products/

# Crawl delay (optional, for aggressive bots)
Crawl-delay: 1
