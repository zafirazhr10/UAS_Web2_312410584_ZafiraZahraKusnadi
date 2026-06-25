# E-Inventory Login Flow Fix - Checklist## Phase 1: Diagnostic & Fix (Critical)
- [ ] Check `backend-api/app/Controllers/Auth.php` for proper input retrieval via `$this->request->getJSON()`
- [ ] Verify password check uses `password_verify($password, $user['password'])`
- [ ] Ensure JSON responses with correct status codes (200/401/500)
- [ ] Examine `backend-api/app/Filters/Cors.php` for OPTIONS preflight handling
- [ ] Confirm Cors filter is registered in `app/Config/Filters.php` `before` array
- [ ] Inspect `frontend-spa/app.js` for correct `axios.post` JSON payload
- [ ] Validate successful token assignment to `localStorage.setItem('token', response.data.token)`
- [ ] Check Axios Request Interceptor for Authorization header injection

## Phase 2: UAS Compliance Audit- [ ] Verify backend returns pure JSON (RESTful) not views
- [ ] Confirm `barang` DB relation links to `kategori`
- [ ] Ensure README contains run instructions for both CI4 and Python/SimpleHTTP servers## Phase 3: Verification
- [ ] Create test script for POST /api/login returning JWT
- [ ] Test GET /api/barang with Authorization header bearing token
- [ ] Document exact fixed code lines causing login failure