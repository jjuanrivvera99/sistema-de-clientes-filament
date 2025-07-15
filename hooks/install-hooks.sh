#!/bin/bash

# Install Git Hooks for Laravel Code Quality
# This script installs pre-commit hooks that automatically run PHPStan and Pint

echo "🔧 Installing Git hooks for Laravel code quality..."

# Check if we're in a git repository
if [ ! -d ".git" ]; then
    echo "❌ Error: Not in a git repository"
    exit 1
fi

# Check if hooks directory exists
if [ ! -d "hooks" ]; then
    echo "❌ Error: hooks directory not found"
    exit 1
fi

# Install pre-commit hook
echo "  📋 Installing pre-commit hook..."
cp hooks/pre-commit .git/hooks/pre-commit
chmod +x .git/hooks/pre-commit

echo "  ✅ Pre-commit hook installed successfully!"

# Verify installation
if [ -x ".git/hooks/pre-commit" ]; then
    echo "  🔍 Hook verification: ✅ pre-commit hook is executable"
else
    echo "  🔍 Hook verification: ❌ pre-commit hook is not executable"
    exit 1
fi

echo ""
echo "🎉 Git hooks installed successfully!"
echo ""
echo "ℹ️  The pre-commit hook will now run automatically before each commit and will:"
echo "   • Check code style with Laravel Pint"
echo "   • Perform static analysis with PHPStan"
echo "   • Auto-fix code style issues"
echo "   • Prevent commits that don't meet quality standards"
echo ""
echo "To skip hooks (not recommended), use: git commit --no-verify"