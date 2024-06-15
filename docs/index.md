---
layout: home
title: Cart
titleTemplate: Simplifying Shopping Cart Management for Laravel

hero:
  name: "Cart"
  text: "Simplifying Shopping Cart Management for Laravel"
  tagline: Streamlined Cart Operations for Laravel-powered E-commerce
  image:
    src: /logo-large.svg
    alt: Cart
  actions:
    - theme: brand
      text: Get Started
      link: /guide/introduction
    - theme: alt
      text: View On Github
      link: https://github.com/realrashid/cart

features:
  - icon: ⚡️
    title: Powerful and Flexible
    details: Cart provides a comprehensive solution for all things cart-related. Customize and adapt it to suit your specific needs with ease.
  - icon: 🚀
    title: Streamlined Operations
    details: Add products, calculate totals, and manage your cart effortlessly. Cart ensures a seamless shopping experience for your customers.
  - icon: 💼
    title: Multiple Instances
    details: Define and manage multiple cart instances, allowing for different configurations for various use cases.
  - icon: 🛠️
    title: Easy Integration
    details: With simple installation steps, you can quickly empower your online store with Cart's powerful cart management capabilities.

---

<style>
:root {
  --vp-home-hero-name-color: transparent;
  --vp-home-hero-name-background: -webkit-linear-gradient(120deg, #047857 30%, #14532d);

  --vp-home-hero-image-background-image: linear-gradient(120deg, #34d399 50%, #059669 50%);
  --vp-home-hero-image-filter: blur(40px);
}

.VPLink.no-icon.VPFeature {
  transition: transform 0.3s ease, box-shadow 0.3s ease, color 0.3s ease;
}

.VPLink.no-icon.VPFeature:hover {
  transform: translateY(-5px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  border-width: 3px;
  border-style: solid;
  border-image: linear-gradient(120deg, #047857 30%, #14532d 50%) 1;
}

.VPLink.no-icon.VPFeature:hover .icon {
  /* background-color: #fff; */
}

.VPLink.no-icon.VPFeature:hover .details {
  /* color: #fff; */
}

@media (min-width: 640px) {
  :root {
    --vp-home-hero-image-filter: blur(56px);
  }
}

@media (min-width: 960px) {
  :root {
    --vp-home-hero-image-filter: blur(72px);
  }
}
</style>
