# AGENTS.md

## Project Context
- **Framework:** Laravel 13 (PHP 8.3)
- **Frontend:** Blade, Tailwind CSS (v4), Alpine.js
- **Database:** MySQL
- **Key Integrations:** Midtrans Snap API, Simple QrCode Generator

## Development Commands
- **Install & Setup:** `composer run setup`
- **Development Server:** `composer run dev` (Runs server, queue, logs, and Vite concurrently)
- **Run Tests:** `composer run test`
- **Build Assets:** `npm run build && npm run dev`
- **Frontend Build:** `npm run build`

## Project Quirks & Conventions
- **UI/UX Style:** Neobrutalism (Bold typography, high contrast, thick black borders)
- **UI Design Tokens:**
  - **Primary Colors:** Yellow #FFD43B, Pink #FF4D8D, Cyan #4CC9F0
  - **Neutral Background:** Black #000000, White #FFFFFF
  - **Borders:** 3-4px solid black coordinates
  - **Shadows:** Offset 6px, Blur 0px, Pure Black color
  - **Radii:** 16px (buttons/input), 20px (cards), 24px (modals)
  - **Box Shadow:** `shadow-neobrutalism` = `6px 6px 0px 0px #000000`
- **Animation Constraints:**
  - Motion limited to 150-250ms durations
  - Scale hover effects only
  - No glassmorphism/blur effects
  - No gradients/transparency animations
- **Mobile-First:** Desktop-first implementation, minimum 375px breakpoint

## Core Features Implementation
- **Ticket Booking:** Midtrans integration with QR code e-ticket generation
- **Project Structure:** Standard Laravel 13 with `/app/Http/Controllers` for API endpoints
- **Design Implementation:** Follow `PRD ADVANCED.md` sections 5-7 and 13-16 exactly
- **Frontend Assets:** Tailwind CSS with custom Neobrutalism tokens in `tailwind.config.js`