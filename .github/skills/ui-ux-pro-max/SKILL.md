---
name: ui-ux-pro-max
description: "Design and implement polished UI/UX for web, mobile, and desktop interfaces. Use when building, reviewing, fixing, or improving pages, components, design systems, accessibility, responsive layouts, typography, color, charts, animation, or stack-specific UI."
argument-hint: "Describe the interface, product, platform, and implementation stack."
user-invocable: true
---

# UI UX Pro Max

Use this skill to turn a product request into an intentional, accessible, responsive interface with a coherent visual system. The installed catalog and search engine are available under `../../prompts/ui-ux-pro-max/`.

## Workflow

### 1. Read the request and inspect the project

Identify the product type, audience, platform, visual intent, interaction needs, and implementation stack. Inspect the existing project before choosing a direction; preserve an established design system when one exists.

### 2. Generate the design direction

For a new page or product-wide visual direction, run the design-system search from the project root:

```powershell
python .github/prompts/ui-ux-pro-max/scripts/search.py "<product> <industry> <keywords>" --design-system -p "<Project Name>"
```

Use `--persist` with `--output-dir "<project-root>"` when the design system should be retained for later work. Read an existing `design-system/<project-slug>/MASTER.md` first, then check a matching page override before implementing a page.

### 3. Search targeted guidance

Use one focused query for the main concern instead of combining unrelated topics:

```powershell
python .github/prompts/ui-ux-pro-max/scripts/search.py "<query>" --domain <product|style|color|typography|landing|chart|ux|gsap|icons|google-fonts>
python .github/prompts/ui-ux-pro-max/scripts/search.py "<query>" --stack <react|nextjs|vue|laravel|html-tailwind|...>
```

For accessibility, text overflow, compact controls, and interrupted animations, search the observable UX outcome first, then the implementation stack. Verify the returned category and top result fit the product before using the guidance.

### 4. Implement with restraint and quality

- Establish tokens for color, type, spacing, radii, shadows, and motion before styling repeated UI.
- Use purposeful typography, strong hierarchy, and a varied palette appropriate to the product rather than defaulting to generic or purple-heavy treatments.
- Prefer real visual assets when the user needs to inspect a product, place, object, or state.
- Use semantic HTML, keyboard access, visible focus, sufficient contrast, labeled icon buttons, and reduced-motion support.
- Keep layouts resilient: long labels, chips, headings, URLs, browser zoom, text scaling, and narrow viewports must reflow without clipping or overlap.
- Use familiar icon libraries already present in the project; do not substitute emoji for interface icons.
- Match the existing framework and component conventions. Do not install packages or change the operating system as part of this skill.

### 5. Validate before delivery

Check the implemented behavior at narrow and wide viewports, including 375px, 768px, 1024px, and 1440px where applicable. Verify focus order, contrast, hover and active states, loading and empty states, reduced motion, and text wrapping. Run the project tests, lint, typecheck, or build command available for the touched slice.

## Search asset location

The CLI-installed catalog and scripts live at:

- `../../prompts/ui-ux-pro-max/scripts/search.py`
- `../../prompts/ui-ux-pro-max/data/`

On Windows, use `python` rather than `python3`. Python 3 is required; do not install it automatically. If it is unavailable, tell the user to install it or continue with the workflow guidance without catalog searches.