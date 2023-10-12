FROM dpage/pgadmin4

COPY server.json import.json
RUN /venv/bin/python3 /pgadmin4/setup.py --load-servers import.json

