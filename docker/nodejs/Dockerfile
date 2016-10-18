FROM node

# Install Bower & Grunt
RUN npm install -g bower grunt-cli

RUN useradd -ms /bin/bash vagrant

# Define working directory.
WORKDIR /app

USER vagrant

CMD ["bash"]