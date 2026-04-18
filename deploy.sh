#!/bin/bash

# Deployment script for Sakura Florist Solo
# Author: Antigravity

echo "🚀 Starting deployment for Sakura Florist Solo..."

# Check if Docker is installed
if ! [ -x "$(command -v docker)" ]; then
  echo "❌ Error: docker is not installed." >&2
  exit 1
fi

# Check if Docker Compose is installed
if ! [ -x "$(command -v docker-compose)" ]; then
  if ! docker compose version > /dev/null 2>&1; then
    echo "❌ Error: docker-compose is not installed." >&2
    exit 1
  fi
  DOCKER_COMPOSE="docker compose"
else
  DOCKER_COMPOSE="docker-compose"
fi

echo "📦 Building and starting containers..."

# Check for docker socket permissions
if ! docker ps > /dev/null 2>&1; then
  echo "⚠️  Docker permission denied. Trying with 'sudo'..."
  SUDO="sudo"
else
  SUDO=""
fi

$SUDO $DOCKER_COMPOSE up --build -d

if [ $? -ne 0 ]; then
  echo "❌ Error: Failed to start containers."
  echo "💡 Hint: Try running 'newgrp docker' to apply group changes without logging out,"
  echo "   or run this script with 'sudo ./deploy.sh'."
  exit 1
fi

echo "⏳ Waiting for MySQL to initialize..."
sleep 5

echo "✅ Deployment complete!"
echo "🌐 Your application is running at: http://localhost"
echo "📂 Admin panel: http://localhost/admin"
echo ""
echo "📝 To view logs, run: $DOCKER_COMPOSE logs -f"
echo "🛑 To stop the application, run: $DOCKER_COMPOSE down"
