# Azams

A roast/folklore web app: the visitor picks a category (MOMIN or PAPI), gets roasted by an AI regardless of choice, and — on the PAPI path — is shown an ongoing folklore story that continues across visits.

This is a closed-contributor project. **All pull requests are reviewed by the project owner before merge.** This document exists so review is fast and consistent, not a formality — read it before opening a PR.

---

## 0. Getting Started — Your First Contribution

Never used Git or GitHub before? This section is for you. Pick the path that fits what you're doing.

### If you're just uploading media files (photos, audio, video) — no software needed

This is the easiest path, entirely in your web browser:

1. Open the project's repository page on GitHub.com.
2. Navigate to `assets/archive/`, then into `images`, `audio`, or `video` depending on what you're adding.
3. Click **"Add file"** → **"Upload files"**.
4. Drag your file in, write a short description of what it is, and click the green button at the bottom.
5. GitHub will ask if you want to create a new branch and start a pull request — click yes/confirm. You're done — someone will review it from here.

You never touch code, never install anything, never type a terminal command.

### If you're making actual code/content changes — recommended app: GitHub Desktop

GitHub Desktop is a free app with buttons instead of typed commands — much friendlier if you're not used to a terminal.

1. Download and install **GitHub Desktop**: https://desktop.github.com
2. Sign in with your GitHub account.
3. Click **"Clone a repository"**, pick this project, choose a folder on your computer.
4. Click **"Current branch"** → **"New branch"**, give it a short name describing what you're doing (e.g. `add-intro-music`), click **"Create branch"**.
5. Make your changes in the project folder using any editor (or drop files into `assets/archive/...` using Finder/File Explorer).
6. Back in GitHub Desktop, you'll see your changes listed. Type a short summary at the bottom left (e.g. "Add intro music clip"), click **"Commit to [your-branch-name]"**.
7. Click **"Push origin"** at the top — this uploads your commit to GitHub.
8. Click **"Create Pull Request"** — this opens GitHub.com with your changes ready to submit. Add a short description of what you did, click **"Create pull request"**.
9. Wait for review. You'll get a notification if changes are requested or it's approved and merged.

### If you're comfortable with the terminal

```zsh
git clone <repo-url>
cd Azams
git checkout -b feature/short-description
# ...make your changes...
git add .
git status                          # confirm nothing unexpected (like .env) is staged
git commit -m "Short description of what changed"
git push -u origin feature/short-description
```

Then go to the repo on GitHub.com — it'll show a banner offering to open a pull request from your just-pushed branch. Click it, add a short description, submit.

### What happens after you submit a Pull Request

The project owner reviews every PR before it's merged into the main project. You may get comments asking for a small change — that's normal, not a rejection. Once approved, it gets merged and your contribution is officially part of the project.

---

## 1. Tech Stack

| Layer | Choice |
|---|---|
| Frontend | Plain HTML/CSS/vanilla JS — no framework |
| Backend | PHP, no framework, served via PHP's built-in dev server locally |
| Database | MySQL 8.4 (Homebrew install) |
| Roast text AI | Google Gemini API |
| Character image AI | Pollinations.ai (free, no auth) |
| Fonts | Fraunces (display), Inter (body), IBM Plex Mono (kicker labels), Noto Sans Bengali (Bangla text) |

No build step, no package manager for the frontend, no Composer for PHP. Keep it that way unless there's a real need.

---

## 2. Project Structure
Azams/
├── config/
│ ├── db.php
│ └── env.php
├── api/
│ ├── generate_roast.php
│ ├── generate_character.php
│ └── lib/
│ ├── roast_lib.php
│ └── character_lib.php
├── public/
│ ├── index.php
│ ├── choice.php
│ ├── momin.php
│ └── papi.php
├── assets/
│ ├── css/style.css
│ ├── js/cursor-follow.js
│ ├── icons/
│ ├── generated/ # AI-generated images, gitignored
│ └── archive/ # community-contributed media — see section 3
│ ├── images/
│ ├── audio/
│ └── video/
├── db/
│ └── seed_folklore.php
├── sql/
│ └── folklore_schema.sql
├── .env # gitignored
└── .gitignore


**Server note:** run `php -S localhost:8000` from the project root (not `-t public`), so both `/public/*` pages and `/api/*` endpoints are reachable. URLs are `http://localhost:8000/public/whatever.php`.

---

## 3. Media Archive (`assets/archive/`)

A place for non-developer contributors to add audio, video, and images without touching any code. See Section 0 above for how to upload a file.

**Folder layout:** `images/`, `audio/`, `video/` — self-explanatory, each has its own short README.

**For developers wiring an archived file into a page** — three default-styled classes exist in `style.css` so any archive media gets consistent look-and-feel automatically, no per-use custom CSS needed:

```html
<img class="archive-image" src="../assets/archive/images/filename.jpg" alt="description">
<video class="archive-video" src="../assets/archive/video/filename.mp4" controls></video>
<audio class="archive-audio" src="../assets/archive/audio/filename.mp3" controls></audio>
```

`.archive-image` and `.archive-video` get consistent max-width, rounded corners, and a border matching the rest of the design. `.archive-audio` gets consistent width. Note: native browser audio/video *controls* (play button, scrubber) can't be deeply restyled cross-browser — these classes handle sizing/framing, not a fully custom player skin.

---

## 4. Database Schema (current, as actually deployed)

Run `SHOW TABLES;` / `DESCRIBE <table>;` against your local `azams_db` to confirm — this is a reference, not a substitute for checking the real thing.

- **`roast_history`** — `id, session_name, choice_made, roast_text, created_at`.
- **`folklore_stories`** — `id, title, culture, total_parts, moral, created_at`.
- **`folklore_parts`** — `id, story_id (FK), part_number, content`.
- **`user_story_progress`** — `id, session_name, story_id, current_part, completed, updated_at`. Unique on `(session_name, story_id)`.

New tables or column changes: add a numbered `.sql` migration file under `sql/` rather than editing an old schema file in place.

---

## 5. Functions & Naming Conventions

**PHP functions:** `camelCase`, verb-first — `generateRoastText()`, `generateCharacterImage()`, `loadEnv()`. Keep generation/API-calling logic in `api/lib/*.php` as standalone functions that return a value or `null` on failure — don't `die()`/`echo` from inside a lib function.

**PHP files:** `snake_case.php`.

**Database access:** always `mysqli` prepared statements with bound parameters. Never interpolate a variable directly into SQL, even values you think are "safe."

**Error handling pattern:** a lib function returns `null` on failure. The calling page decides what to show — a fallback string, or `http_response_code(500)` for a JSON endpoint.

---

## 6. CSS / Styling Conventions

All design tokens live in `:root` at the top of `assets/css/style.css`:

```css
--color-char-black, --color-cream, --color-smoke-gray, --color-ember, --color-moss
--font-display, --font-sans, --font-mono, --font-bengali
```

Add a token here first if a new color/font is genuinely needed — don't drop raw values into component rules.

**Class naming:** flat, descriptive, kebab-case — `.choice-card`, `.speech-bubble`, `.archive-image`. No BEM double-underscore convention.

**Bangla text:** any element with Bangla script needs `lang="bn"` (triggers the `--font-bengali` rule) and `Noto+Sans+Bengali` in that page's Google Fonts `<link>`.

---

## 7. HTML IDs

Prefer classes for styling, always. Reserve `id` for JS hooks needing one specific element, or in-page anchors. If you're adding an `id` purely for CSS, use a class instead.

---

## 8. AI Models In Use

**This section goes stale fast — verify current model availability before assuming anything below still works.**

| Purpose | Provider | Current model / endpoint | Called from |
|---|---|---|---|
| Roast text | Google Gemini API | `gemini-3.6-flash` via `generateContent` | `api/lib/roast_lib.php` |
| Character image | Pollinations.ai | `image.pollinations.ai/prompt/...?model=flux` (free, no key) | `api/lib/character_lib.php` |

Don't switch either without updating this table in the same PR. `HF_API_KEY` exists in `.env` as reserved/unused for now.

---

## 9. Environment Variables

`.env` (gitignored, never commit):

Loaded via `config/env.php`'s `loadEnv()` — access with `getenv('KEY_NAME')`.

---

## 10. Commit & PR Guidance (quick reference — see Section 0 for full walkthrough)

- Branch naming: `feature/short-description`.
- Run `php -l` on every PHP file you touched, before committing.
- Run `git status` before committing — confirm `.env` and nothing under `assets/generated/` is staged.
- Commit messages: short, imperative, present tense.
- All merges require project-owner review. Don't merge your own PR.

---

## 11. Content Guidelines

User-facing text — choice labels, category names, roast copy — should stay playful/lighthearted and avoid vulgar language or slurs, regardless of internal "closed community" context. Flag uncertain wording in the PR description rather than assuming and merging.

---

## 12. Known Gotchas (living list)

- Run the PHP server from the project root, not `-t public`, or `/api/*` becomes unreachable.
- Terminal copy-paste can silently corrupt longer files — `php -l` and/or `cat` a file back out after editing to confirm it matches intent.
- `set_time_limit()` and `ini_set('max_execution_time', ...)` are both needed together on pages calling slow external APIs.
- This project assumes Homebrew's `mysql@8.4`, managed via `brew services` — avoid mixing with an Oracle `.pkg` MySQL install.
EOF

php -l README.md 2>/dev/null || echo "(markdown, no lint needed — confirming write)"
ls -la assets/archive/ assets/archive/images assets/archive/audio assets/archive/video
cat assets/css/style.css | tail -20
