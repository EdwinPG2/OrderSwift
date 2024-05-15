FROM nginx:1.22-alpine

COPY ./ibizdevelopers.key /etc/nginx/conf.d/ibizdevelopers.key
COPY ./ibizdevelopers.pem /etc/nginx/conf.d/ibizdevelopers.pem
COPY ./proxy_options.conf /proxy_options.conf
COPY ./redirects.conf /redirects.conf
COPY ./default.conf /etc/nginx/conf.d/default.conf