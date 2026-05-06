# Artist System Documentation

## Overview

The MyDrim Gallery now uses a **single-template dynamic system** for artist pages instead of individual HTML files. This means:

- **One template file**: `artist.html` loads artist data dynamically
- **One artists directory**: `artists.html` displays all artists
- **JSON data source**: `data/artists.json` contains all artist information
- **URL parameters**: Artists are selected via query strings: `artist.html?id=abiodun`

## Benefits

✅ **Easier Maintenance**: Update artist info in one JSON file instead of multiple HTML files  
✅ **Scalability**: Add 100 artists without adding 100 HTML files  
✅ **Consistency**: All artist pages have the same layout and structure  
✅ **Smaller Site**: Fewer files = faster deployment  
✅ **SEO-Friendly**: URL parameters work well with search engines  

## File Structure

```
MyDrim/
├── artist.html              # Single artist profile template (loads data via URL parameter)
├── artists.html             # Artists directory/gallery (lists all artists)
├── data/
│   └── artists.json         # Artist data (name, bio, image, etc.)
```

## How It Works

### 1. Artists Directory (`artists.html`)
When users visit `/artists.html`, the page:
1. Loads `data/artists.json`
2. Dynamically creates artist cards for each artist
3. Each card links to: `artist.html?id=abiodun` (or bruce, fidelis, wallace, etc.)

### 2. Individual Artist Page (`artist.html`)
When users visit `artist.html?id=abiodun`, the page:
1. Reads the URL parameter `id=abiodun`
2. Loads `data/artists.json`
3. Finds the artist with ID "abiodun"
4. Displays the artist's information

## Adding a New Artist

### Step 1: Add Artist Data to `data/artists.json`

Edit `data/artists.json` and add a new artist object:

```json
{
  "artists": [
    {
      "id": "new-artist",
      "slug": "new-artist-name",
      "name": "NEW ARTIST NAME",
      "born": "b. 1960",
      "image": "img/Artists/New Artist/photo.webp",
      "title": "NEW ARTIST NAME",
      "bio": "Artist biography here..."
    }
    // ... other artists
  ]
}
```

### Step 2: Upload Artist Image

1. Create a folder in `img/Artists/` named after the artist
2. Upload a portrait image of the artist
3. Reference it in the JSON:
   ```
   "image": "img/Artists/Artist Name/photo.webp"
   ```

### Step 3: Done!

The new artist will automatically appear in:
- The `/artists.html` gallery page
- Accessible at `artist.html?id=new-artist`

## JSON Data Format

Each artist object should contain:

| Field | Type | Example | Required |
|-------|------|---------|----------|
| `id` | string | "abiodun" | Yes |
| `slug` | string | "abiodun-olaku" | Yes |
| `name` | string | "ABIODUN OLAKU" | Yes |
| `born` | string | "b. 1958" | No |
| `image` | string | "img/Artists/.../photo.webp" | Yes |
| `title` | string | "ABIODUN OLAKU" | Yes |
| `bio` | string | "Long biography text..." | Yes |

### Notes:
- `id` is used in URLs: `artist.html?id=abiodun`
- `bio` can contain `\n` for line breaks
- Image paths should be relative to the root directory
- Keep IDs lowercase and use hyphens (not spaces or underscores)

## Example: Adding Bruce Onobrakpeya

**JSON Entry:**
```json
{
  "id": "bruce",
  "slug": "bruce-onobrakpeya",
  "name": "BRUCE ONOBRAKPEYA",
  "born": "PhD MFR b. 1932",
  "image": "img/Artists/Bruce Onobrakpeya/Bruce Onobrakpeya.webp",
  "title": "BRUCE ONOBRAKPEYA PhD",
  "bio": "Bruce Onobrakpeya is a legendary Nigerian Master Artist...\n\nThe description continues..."
}
```

**URL to access:**
```
artist.html?id=bruce
```

## Updating Artist Information

1. Open `data/artists.json`
2. Find the artist by their `id`
3. Update any field (name, bio, image, etc.)
4. Save the file
5. Refresh the website - changes appear immediately

## Current Artists

| ID | Name | File | Birth |
|----|------|------|-------|
| abiodun | Abiodun Olaku | img/Artists/Abiodun Olaku/ | b. 1958 |
| bruce | Bruce Onobrakpeya | img/Artists/Bruce Onobrakpeya/ | b. 1932 |
| fidelis | Fidelis Odogwu | img/Artists/Fidelis Odogwu/ | b. 1970 |
| wallace | Wallace Ejor | img/Artists/Wallace Ejor Works/ | b. 1958 |

## Technical Details

### How URLs Work

```
artist.html?id=abiodun
         ↓
JavaScript reads "abiodun" from URL
         ↓
Searches artists.json for id="abiodun"
         ↓
Found! Display Abiodun Olaku's data
```

### Browser Navigation

Users can link directly:
```html
<a href="artist.html?id=bruce">View Bruce Onobrakpeya</a>
```

Or navigate from the artists gallery which auto-generates links:
```html
<a href="artist.html?id=bruce">Bruce Onobrakpeya</a>
```

## Linking to Artist Pages

### From other pages:
```html
<!-- From index.html or any page -->
<a href="artist.html?id=abiodun">Abiodun Olaku</a>
<a href="artist.html?id=bruce">Bruce Onobrakpeya</a>
<a href="artist.html?id=fidelis">Fidelis Odogwu</a>
<a href="artist.html?id=wallace">Wallace Ejor</a>
```

### From the artists gallery:
```html
<!-- From artists.html -->
<a href="artist.html?id=abiodun">
  <img src="img/Artists/Abiodun Olaku/..." alt="">
  <h4>Abiodun Olaku</h4>
</a>
```

## SEO Considerations

**URL Structure:**
```
artist.html?id=abiodun
```

To make URLs more SEO-friendly, consider implementing:
```
artist/abiodun/
artist/abiodun-olaku/
```

This would require server-side routing (PHP, Node.js, etc.).

For now, the query parameter approach works well and is easily indexed by search engines.

## Troubleshooting

### Artist Page Shows "Artist Not Found"
- Check that the `id` in the URL matches an artist's `id` in `data/artists.json`
- Example: `artist.html?id=typo` won't work if no artist has `"id": "typo"`

### Image Not Loading
- Verify the image path exists: `img/Artists/Artist Name/photo.webp`
- Check file name capitalization (case-sensitive on Linux servers)
- Use relative paths, not absolute

### Bio Not Displaying
- Ensure bio text is properly escaped in JSON
- Use `\n` for line breaks (not actual newlines)
- Single quotes within bio text should be escaped: `\'`

### Page Not Updating After JSON Edit
- Clear browser cache (Ctrl+F5 or Cmd+Shift+R)
- Make sure JSON syntax is valid (check for missing commas, quotes)

## Future Enhancements

Possible improvements:
1. **Add more fields**: Awards, exhibitions, website URL, contact
2. **Add categories**: Painter, Sculptor, Printmaker, etc.
3. **Gallery per artist**: Multiple artwork images per artist
4. **Filtering**: Show artists by medium, style, or year
5. **Search**: Find artists by name or bio
6. **Server-side routes**: Clean URLs like `/artist/abiodun/`
7. **CMS integration**: Manage artists through admin panel

## Files Modified/Created

### Created Files
- `data/artists.json` - Artist database
- `artists.html` - Artists directory page
- This documentation file

### Modified Files
- `artist.html` - Converted to dynamic template

### Deleted Files
- `Abiodun-olaku.html` - Consolidated into system
- `Bruce Onobrakpeya.html` - Consolidated into system
- `Fidelis-odogwu.html` - Consolidated into system
- `Wallace-Ejor.html` - Consolidated into system
- `artist-single.html` - Replaced by new artist.html

## Summary

The new artist system is **simpler, scalable, and maintainable**. Adding artists now takes minutes, not creating new HTML files. All artist profiles are consistent and automatically linked from the gallery page.

---

**Last Updated**: April 2025  
**System Version**: 1.0


