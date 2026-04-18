#!/bin/bash

# Docker and Docker Compose Installation Script for Ubuntu Server
# Author: Antigravity AI

echo "🚀 Starting Docker installation on Ubuntu Server..."

# 1. Update package index
sudo apt-get update

# 2. Install prerequisites
sudo apt-get install -y \
    ca-certificates \
    curl \
    gnupg \
    lsb-release

# 3. Add Docker's official GPG key
sudo mkdir -p /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg

# 4. Set up the repository
echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu \
  $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

# 5. Install Docker Engine
sudo apt-get update
sudo apt-get install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin

# 6. Verify installation
sudo docker --version
docker compose version

# 7. Post-installation steps (optional but recommended: allow running docker without sudo)
echo "🔧 Configuring Docker to run without sudo (requires logout/login to take effect)..."
sudo usermod -aG docker $USER

echo "✅ Docker installation complete!"
echo "⚠️ Note: Please log out and log back in to use Docker without 'sudo'."
