FROM node:lts-alpine
# make the 'app' folder the current working directory
WORKDIR /usr/src/app
# copy 'package.json' to install dependencies
COPY package*.json ./
# install dependencies
RUN npm install
# copy files and folders to the current working directory (i.e. 'app' folder)
COPY . .
# build app for production with minification
CMD ["npm", "run", "dev"]