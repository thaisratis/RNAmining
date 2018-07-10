FROM nginx

COPY ./nginx.conf /etc/nginx/nginx.conf

COPY ./mdp.conf /etc/nginx/conf.d/default.conf

RUN mkdir -p /var/www/html/

RUN chown www-data.www-data /var/www/html/ -R

RUN chmod u+s /var/www/html/ -R
