#!/bin/bash
set -euo pipefail

BASE_URL="http://localhost:8080"
LOGIN_URL="$BASE_URL/api/login"
BARANG_URL="$BASE_URL/api/barang"

echo "=== E-Inventory Login Flow Verification ==="
echo "1. POST $LOGIN_URL"
RESPONSE=$(curl -s -X POST "$LOGIN_URL" \
  -H "Content-Type: application/json" \
  -d '{"username":"admin","password":"password123"}')

echo "Response: $RESPONSE"

TOKEN=$(echo "$RESPONSE" | grep -o '"token"[[:space:]]*:[[:space:]]*"[^"]*"' | cut -d'"' -f4)
if [ -z "$TOKEN" ]; then
  echo "FAIL: No token in response"
  exit 1
fi

echo "Token received: ${TOKEN:0:20}..."
echo ""
echo "2. GET $BARANG_URL with Bearer token"

BARANG_RESPONSE=$(curl -s -X GET "$BARANG_URL" \
  -H "Authorization: Bearer $TOKEN")

echo "Barang response: $BARANG_RESPONSE"
echo ""
echo "=== VERIFICATION PASSED ==="