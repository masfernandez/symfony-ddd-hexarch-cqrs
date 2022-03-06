ARG NGINX_VERSION=1.21.6

# --------------------------------------------
# base stage
# --------------------------------------------
FROM nginx:${NGINX_VERSION}-alpine as base

LABEL maintainer="Miguel Ángel Sánchez Fernández <mangel.sanfer@gmail.com>"

# --------------------------------------------
# development stage
# --------------------------------------------
FROM base as dev

# --------------------------------------------
# production stage
# --------------------------------------------
FROM base as prod